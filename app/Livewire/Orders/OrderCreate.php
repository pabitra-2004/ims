<?php

namespace App\Livewire\Orders;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Computed;
use Livewire\Component;

class OrderCreate extends Component
{
    public string $search = '';

    public array $filter = [
        'categories' => [],
    ];
    public $categories = [];
   

    public array $selected_products = [];

    public function mount()
    {
        Product::inRandomOrder()->take(4)->get()->each(fn ($product) => $this->addToCart($product));

        $products = Product::select('category_id')->distinct();
        $this->categories = Category::select('id', 'name')
            ->whereIn('id', $products)
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    #[Computed()]
    public function products()
    {
        return Product::with(['category:id,name'])->search($this->search)->filter($this->filter)->latest()->get();
    }

    public function addToCart(Product $product)
    {
        // dd($product_id);

        $key = array_search($product->id, array_column($this->selected_products, 'id'));

        if ($key === false) {
            $this->selected_products[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->images[0] ?? null,
                'category' => $product->category->name ?? 'N/A',
                'qty' => 1,
            ];
        } else {
            $this->selected_products[$key]['qty']++;
        }
    }

    public function clearFilters(){
        $this->filter['categories'] = [];
    }

    public function render()
    {
        return view('livewire.orders.order-create');
    }
}
