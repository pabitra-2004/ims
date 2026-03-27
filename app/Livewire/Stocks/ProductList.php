<?php

namespace App\Livewire\Stocks;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public $quantity = 10;

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

    // delete individual
    public function deleteInventory(Product $product)
    {
        $product->delete();
        $this->dispatch('toast-fire', type: 'sucess', message: 'Prdocuct deleted successfully!');
    }

    public function render()
    {
        $products = Product::with([
            'stock:id,product_id,quantity,reserved',
            'category:id,name',
        ])
            ->whereIsActive(true)
            ->paginate($this->quantity);

        // Store current page IDs
        $this->pageProductIds = $products->pluck('id')->toArray();

        return view('livewire.stocks.product-list', [
            'products' => $products,
        ]);
    }
}
