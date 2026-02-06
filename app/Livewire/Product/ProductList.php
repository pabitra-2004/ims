<?php

namespace App\Livewire\Product;

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
        return view('livewire.product.product-list', ['products' => Product::paginate(10)]);
    }
}
