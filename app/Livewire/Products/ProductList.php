<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ProductList extends Component
{
    use WithPagination;

    public int $quantity = 10;
    public ?string $search = '';
    public ?array $filters = [
        'status' => [],
        'categories' => [],
    ];
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';

    public array $categories = [];

    public function mount()
    {
        $this->categories = Category::orderBy('name')->pluck('name', 'id')->toArray();
    }

    #[On('product-saved')]
    public function updateProductList() {}

    public function deleteProduct(Product $product)
    {
        $product->delete();
        $this->dispatch('toast-fire', type: 'success', message: 'Product deleted successfully!');
    }

    public function toggleActiveInactive(Product $product)
    {
        $product->is_active = ! $product->is_active;
        $product->save();
        $this->dispatch('toast-fire', type: 'success', message: 'Product status changed');
    }

    public function clearFilters($key = null)
    {
        if ($key) {
            $this->filters[$key] = [];
        } else {
            $this->reset('filters');
        }
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        return view(
            'livewire.products.product-list',
            [
                'products' => Product::with('category:id,name')
                    ->search($this->search)
                    ->filter($this->filters)
                    ->orderBy($this->sortBy, $this->sortDirection)
                    ->paginate($this->quantity),
            ]
        );
    }
}
