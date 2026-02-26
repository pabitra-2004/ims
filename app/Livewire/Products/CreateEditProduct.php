<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateEditProduct extends Component
{
    #[Locked]
    public ?int $product_id = null;

    public int $category_id;
    public string $code;
    public string $name;
    public $slug;
    public ?string $description = null;

    public array $categories = [];

    public function mount()
    {
        $this->categories = Category::pluck('name', 'id')->toArray();
    }

    #[On('edit-product')]
    public function loadProduct(Product $product)
    {
        $this->product_id = $product->id;
        $this->category_id = $product->category_id;
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
            'category_id' => 'required|integer',
            'code' => ['required', 'string', 'size:6', 'regex:/^[A-Z0-9]{6}$/', Rule::unique('products', 'code')->ignore($this->product_id)],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('products', 'slug')->ignore($this->product_id)],
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrNew($this->product_id);
        $product->category_id = $this->category_id;
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
        $this->reset(['category_id', 'code', 'name', 'slug', 'description']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.products.create-edit-product');
    }
}
