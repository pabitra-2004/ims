<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class ProductView extends Component
{
    public int $product_id;

    public function mount(int $product_id)
    {
        $this->product_id = $product_id;
    }

    public function render()
    {
        return view('livewire.products.product-view', [
            'product' => Product::query()
                ->where('id', $this->product_id)
                ->first(),
        ]);
    }
}
