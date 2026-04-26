<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Livewire\Component;

class UpdateStock extends Component
{
    public ?string $search_product = '';

    public ?int $product_id;
    public $category_id;
    public $code;
    public $name;
    public $slug;
    public $description;
    public $quantity;
    public $existing_photo = null;

    public $categories = [];

     public function mount()
    {
        $products = Product::distinct()->pluck('category_id');
        $this->categories = Category::select('id', 'name')
            ->whereIn('id', $products)
            ->orderBy('name')
            ->get()
            ->toArray();
    }   

    public function selectProduct($id)
    {
        $product = Product::with('inventory')->find($id);
        $this->product_id = $product->id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->existing_photo = $product->photo;
        $this->category_id = $product->category_id;
        $this->description = $product->description;

        $this->quantity = $product->inventory?->quantity ?? 0;
        // dd($this->quantity);
    }

    public function save()
    {
        Inventory::updateOrCreate(
            ['product_id' => $this->product_id],
            ['quantity' => $this->quantity]
        );

        $this->dispatch('refresh-page');
        $this->close();
    }

    public function close()
    {
        $this->reset(['search_product', 'category_id', 'product_id', 'code', 'name', 'slug', 'description', 'quantity', 'existing_photo']);
        $this->modal('update-stock')->close();
    }

    public function render()
    {
        $products = Product::with([
            'inventory:id,product_id,quantity',
            'category:id,name',
        ])
        ->search($this->search_product)
        ->get();

        return view('livewire.update-stock')->with([
            'products' => $products,
        ]);
    }
}
