<?php

namespace App\Livewire\Orders;

use App\Models\Product;
use Livewire\Component;

class CreateOrder extends Component
{
    // public string $search = '';

    // public $cart = [];

    // public function addToCart($productId)
    // {
    //     $product = Product::findOrFail($productId);

    //     if (isset($this->cart[$productId])) {
    //         $this->cart[$productId]['qty']++;
    //     } else {
    //         $this->cart[$productId] = [
    //             'name' => $product->name,
    //             'category' => $product->category->name,
    //             'price' => $product->price,
    //             'qty' => 1,
    //         ];
    //     }
    // }

    public $search = '';

    public $cart = [];

    public function addToCart($productId)
    {
        $product = Product::with('category')->findOrFail($productId);

        if (isset($this->cart[$productId])) {

            $this->cart[$productId]['qty']++;

        } else {

            $this->cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
                'photo' => $product->photo
                    ? asset('storage/'.$product->photo)
                    : asset('default_images.png'),

                'category' => $product->category->name ?? 'N/A',
            ];
        }
    }


    public function render()
    {
        $products = Product::query()->search($this->search)->latest()->get();

        return view('livewire.orders.create-order', ['products' => $products]);
    }
}
