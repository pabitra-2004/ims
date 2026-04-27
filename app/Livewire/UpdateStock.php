<?php

namespace App\Livewire;

use App\Models\Inventory;
use App\Models\Product;
use Livewire\Component;

class UpdateStock extends Component
{
    public ?string $search_product = '';

    public $product;
    public $quantity = '';

    public function selectProduct($id)
    {
        $this->product = Product::with(['inventory', 'category:id,name'])->find($id);
        $this->quantity = $this->product->inventory?->quantity ?? 0;
    }

    public function save()
    {
        $inventory = Inventory::where('product_id', $this->product->id)->firstOrNew();
        $inventory->product_id = $this->product->id;
        $inventory->quantity = $this->quantity;
        $inventory->save();


        $this->dispatch('refresh-inventory');
        $this->modal('update-stock')->close();
        $this->reset();
    }

    public function render()
    {
        return view('livewire.update-stock')->with([
            'products' => Product::with([
                'inventory:id,product_id,quantity',
                'category:id,name',
            ])
                ->search($this->search_product)
                ->get(),
        ]);
    }
}
