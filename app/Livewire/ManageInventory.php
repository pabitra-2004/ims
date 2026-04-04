<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
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

    public function updatedSelectAll($checked)
    {
        $this->selected = $checked ? $this->pageProductIds : [];
    }

    public function updatedSelected()
    {
        $this->selectAll = ! empty($this->pageProductIds) && count(array_intersect($this->selected, $this->pageProductIds)) === count($this->pageProductIds);
    }

    public function updatingPage($page)
    {
        // dd($page);
        $this->selectAll = false;
        $this->selected = [];
    }

    public function deleteSelected()
    {
        $ids = array_intersect($this->selected, $this->pageProductIds);

        Product::whereIn('id', $ids)->delete();

        $this->selected = array_diff($this->selected, $ids);
        $this->selectAll = false;

        $this->dispatch('toast-fire', type: 'success', message: 'Page products deleted!');
    }

    public function increment(Product $product)
    {
        if ($product->inventory) {
            // $product->inventory->quantity = $product->inventory->quantity + 1;
            // $product->inventory->save();

            $product->inventory->increment('quantity');

        } else {
            $product->inventory()->create(['quantity' => 1]);
        }
    }

    public function decrement(Product $product)
    {
        if ($product->inventory) {
            // dd($product->inventory->decrement('quantity'));
            $product->inventory->decrement('quantity');
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
            ->where(function(Builder $query){
                $in_stock = in_array('in_stock', $this->filters['status']);
                $low_stock = in_array('low_stock', $this->filters['status']);
                $out_of_stock = in_array('out_of_stock', $this->filters['status']);

                if($in_stock & $low_stock & $out_of_stock){}
                elseif($in_stock & $low_stock){
                    $query->whereRelation('inventory', 'quantity', '>', 0);
                }
                elseif($in_stock & $out_of_stock){
                    $query->whereRelation('inventory', 'quantity', '>', 10)
                    ->orWhereRelation('inventory', 'quantity', 0)
                    ->orDoesntHave('inventory');
                }
                elseif($low_stock & $out_of_stock){
                    $query->whereRelation('inventory', 'quantity', '<=', 10)
                    ->orDoesntHave('inventory');
                }
                else{
                    if($in_stock){
                        $query->whereRelation('inventory', 'quantity', '>', 10);
                    }
                    elseif($low_stock){
                        $query->whereHas('inventory', function ($query) {
                            $query->whereBetween('quantity', [1, 10]);
                        });
                    }
                    elseif($out_of_stock){
                        $query->doesntHave('inventory')
                        ->orWhereRelation('inventory', 'quantity', 0);
                    }
                }

            })
            ->paginate($this->perPage);

        // Store current page IDs
        $this->pageProductIds = $products->pluck('id')->toArray();

        return view('livewire.manage-inventory')->with([
            'products' => $products,
        ]);
    }
}
