<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEditProduct extends Component
{
    use WithFileUploads;

        /*--------------------------------------------------------------------------
    | properties
    |--------------------------------------------------------------------------*/
    #[Validate('image|max:2048')] // 2MB Max
    public array $images = [];
    public array $existing_images = [];

    #[Locked]
    public ?int $product_id = null;
    public int $category_id;
    public string $code;
    public string $name;
    public string $slug;
    public float $price;
    public ?string $description = null;
    public array $categories = [];

    /*--------------------------------------------------------------------------
    |lifecycle hooks
    |--------------------------------------------------------------------------*/
    public function mount()
    {
        $this->categories = Category::pluck('name', 'id')->toArray();
    }

    public function updatedName()
    {
        $this->slug = $this->slug ?? Str::slug($this->name);
    }

    /*--------------------------------------------------------------------------
    | Load Product
    |--------------------------------------------------------------------------*/
    #[On('edit-product')]
    public function loadProduct(Product $product)
    {
        $this->product_id = $product->id;
        $this->category_id = $product->category_id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->price = $product->price;
        $this->description = $product->description;
        $this->existing_images = $product->images ?? [];
        $this->images = [];
        $this->modal('create-edit-product')->show();
    }

    /*--------------------------------------------------------------------------
    | actions (create /update)
    |--------------------------------------------------------------------------*/
    public function saveProduct()
    {
        $this->slug = Str::trim($this->slug);

        $this->validate([
            'category_id' => 'required|integer',
            'code' => ['required', 'string', 'size:8', 'regex:/^[A-Z]{3}\d{5}$/', Rule::unique('products', 'code')->ignore($this->product_id)],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('products', 'slug')->ignore($this->product_id)],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => 'nullable|string',

            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // 2MB Max
        ]);

        $product = Product::findOrNew($this->product_id);
        $product->category_id = $this->category_id;
        $product->code = $this->code;
        $product->name = $this->name;
        $product->slug = $this->slug;

        $paths = $this->existing_images ?? [];
        if (! empty($this->images)) {
            foreach ($this->images as $image) {
                $paths[] = $image->store('images/products', 'public');
            }
        }
        $product->images = $paths;
        $product->price = $this->price;
        $product->description = $this->description;

        $product->save();
        $this->dispatch('product-saved');
        $this->modal('create-edit-product')->close();

        $message = $this->product_id ? 'Product updated successfully!' : 'Product added successfully!';
        $this->dispatch('toast-fire', type: 'success', message: $message);

        $this->close();
    }

    /*--------------------------------------------------------------------------
    | Remove Existing Image
    |--------------------------------------------------------------------------*/
    public function removeImage(int $index)
    {
        if (isset($this->existing_images[$index])) {

            Storage::disk('public')->delete(
                $this->existing_images[$index]
            );

            unset($this->existing_images[$index]);

            $this->existing_images = array_values(
                $this->existing_images
            );
        }
    }

    /*--------------------------------------------------------------------------
    | reset
    |--------------------------------------------------------------------------*/
    public function close()
    {
        $this->reset([
            'product_id', 'category_id', 'code', 'name', 'slug', 'price', 'images', 'existing_images', 'description',
        ]);

        $this->resetValidation();
    }

    /*--------------------------------------------------------------------------
    | Render Component
    |--------------------------------------------------------------------------*/
    public function render()
    {
        return view('livewire.products.create-edit-product');
    }
}
