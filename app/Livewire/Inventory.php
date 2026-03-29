<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Inventory extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $selected = [];

    public $selectAll = false;

    public $pageProductIds = [];

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
            ->paginate($this->perPage);

        // Store current page IDs
        $this->pageProductIds = $products->pluck('id')->toArray();

        return view('livewire.inventory')->with([
            'products' => $products,
        ]);
    }
}
