<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public function deleteProduct(Product $product){
        $product->delete();
    }

    public function render()
    {
        return view('livewire.products.product-list', ['products' => Product::paginate(10)]);
    }
}
