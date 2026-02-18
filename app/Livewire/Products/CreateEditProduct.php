<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateEditProduct extends Component
{
    #[Locked]
    public $product_id;

    public $code;

    public $name;

    public $slug;

    public ?string $description = null;

    #[On('edit-product')]
    public function loadProduct(Product $product)
    {
        $this->product_id = $product->id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;

        $this->modal('create-edit-product')->show();
    }

    public function updatedName()
    {
        $this->slug = $this->slug ?? Str::slug($this->name);
    }

    public function saveProduct()
    {
        $this->slug = Str::trim($this->slug);

        $this->validate([
            'code' => ['required', 'string', 'max:13', Rule::unique('products', 'code')->ignore($this->product_id)],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($this->product_id)],
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrNew($this->product_id);
        $product->code = $this->code;
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->description = $this->description;

        $product->save();
        $this->dispatch('product-saved');
        $this->modal('create-edit-product')->close();
        $this->close();
    }

    public function close()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.products.create-edit-product');
    }
}
