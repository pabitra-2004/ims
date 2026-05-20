<?php

namespace App\Livewire\Orders;

use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrderCreate extends Component
{
    public string $search = '';
    public array $selected_products = [];

    public function mount()
    {
        Product::inRandomOrder()->take(4)->get()->each(fn($product) => $this->addToCart($product));
    }

    #[Computed()]
    public function products()
    {
        return Product::with(['category:id,name'])->search($this->search)->latest()->get();
    }

    public function addToCart(Product $product)
    {
        // dd($product_id);

        $key = array_search($product->id, array_column($this->selected_products, 'id'));

        // dd($key);

        if ($key === false)
            $this->selected_products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->images[0],
                'category' => $product->category->name ?? 'N/A',
                'qty' => 1,
            ];
        else {

            $this->selected_products[$key]['qty']++;
        }
    }

    public function render()
    {
        return view('livewire.orders.order-create');
    }
}
