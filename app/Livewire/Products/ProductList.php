<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public int $quantity = 10;

    public ?string $search = '';

    public $status_filters = [];

    #[On('product-saved')]
    public function updateProductList() {}

    public function toggleActiveInactive(Product $product)
    {
        $product->is_active = ! $product->is_active;
        $product->save();
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
    }

    public function clearFilters()
    {
        $this->status_filters = [];
    }

    public function render()
    {
        return view('livewire.products.product-list',
            ['products' => Product::with('category:id,name')
                ->search($this->search)
                ->statusfilter($this->status_filters)
                ->latest('updated_at')
                ->paginate($this->quantity),
            ]
        );
    }
}
