<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    #[On('product-saved')]
    public function updateProductList(){}


    public function toggleActiveInactive(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();
    }

    public function deleteProduct(Product $product){
        $product->delete();
    }

    public function render()
    {
        return view('livewire.products.product-list', ['products' => Product::latest()->paginate(10)]);
    }
}
