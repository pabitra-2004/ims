<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ManageInventory extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $selected = [];

    public $selectAll = false;

    public $pageProductIds = [];

    public ?string $search = '';

    public array $filters = [
        'status' => [],
    ];

    #[On('refresh-inventory')]
    public function refresh() {}

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function updatedSelectAll(bool $checked)
    {
        $this->selected = $checked ? $this->pageProductIds : [];
    }

    public function updatedSelected()
    {
        $this->selectAll = ! empty($this->pageProductIds) && count(array_intersect($this->selected, $this->pageProductIds)) === count($this->pageProductIds);
    }

    public function updatingPage()
    {
        $this->selectAll = false;
        $this->selected = [];
    }

    public function deleteSelected()
    {
        $ids = array_intersect($this->selected, $this->pageProductIds);

        if (empty($ids)) {
            return;
        }

        $products = Product::whereIn('id', $ids)->get();

        foreach ($products as $product) {
            foreach ($product->images ?? [] as $image) {
                Storage::disk('public')->delete($image);
            }

            $product->delete();
        }

        $this->selected = array_diff($this->selected, $ids);
        $this->selectAll = false;

        $this->dispatch('toast-fire', type: 'success', message: 'Selected  products deleted!');
    }

    public function increment(Product $product)
    {
        if ($product->inventory) {
            $product->inventory->increment('quantity', 1);
        } else {
            $product->inventory()->create(['quantity' => 1]);
        }
    }

    public function decrement(Product $product)
    {
        if ($product->inventory) {
            if ($product->inventory?->quantity > 0) {
                $product->inventory()->decrement('quantity');
            }
        }
    }

    public function clearFilters($key = null)
    {
        if ($key) {
            $this->filters[$key] = [];
        } else {
            $this->reset('filters');
            $this->resetPage();
        }
    }

    public function render()
    {
        $products = Product::with([
            'inventory:id,product_id,quantity',
            'category:id,name',
        ])
            ->whereIsActive(true)
            ->search($this->search)
            ->where(function (Builder $query) {
                $in_stock = in_array('in_stock', $this->filters['status']);
                $low_stock = in_array('low_stock', $this->filters['status']);
                $out_of_stock = in_array('out_of_stock', $this->filters['status']);

                if ($in_stock & $low_stock & $out_of_stock) {
                    return ;
                } elseif ($in_stock & $low_stock) {
                    $query->whereRelation('inventory', 'quantity', '>', 0);
                } elseif ($in_stock & $out_of_stock) {
                    $query->whereRelation('inventory', 'quantity', '>', 10)
                        ->orWhereRelation('inventory', 'quantity', 0)
                        ->orDoesntHave('inventory');
                } elseif ($low_stock & $out_of_stock) {
                    $query->whereRelation('inventory', 'quantity', '<=', 10)
                        ->orDoesntHave('inventory');
                } else {
                    if ($in_stock) {
                        $query->whereRelation('inventory', 'quantity', '>', 10);
                    } elseif ($low_stock) {
                        $query->whereHas('inventory', function ($query) {
                            $query->whereBetween('quantity', [1, 10]);
                        });
                    } elseif ($out_of_stock) {
                        $query->doesntHave('inventory')
                            ->orWhereRelation('inventory', 'quantity', 0);
                    }
                }
            })
            ->latest('updated_at')
            ->paginate($this->perPage);

        // Store current page IDs
        $this->pageProductIds = $products->pluck('id')->toArray();

        return view('livewire.manage-inventory')->with([
            'products' => $products,
        ]);
    }
}
