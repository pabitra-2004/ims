<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;

class ProductQuickView extends Component
{
    public ?Product $product = null;
    public string $previewImage;
    public int $previewImageIndex = 0;

    #[On('quick-view-product')]
    public function show(Product $product)
    {
        $this->product = $product;
        $this->previewImage = $product->images[0];
        $this->previewImageIndex = 0;

        $this->modal('quick-view')->show();
    }

    public function render()
    {
        return view('livewire.products.product-quick-view');
    }
}
