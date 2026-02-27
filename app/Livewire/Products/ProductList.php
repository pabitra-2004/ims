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

    public ?array $status_filters = [];

    public array $categories = [];
    public ?array $category_filters = [];


    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';

    public function mount()
    {
        $this->categories = Category::orderBy('name')->pluck('name', 'id')->toArray();
    }

    #[On('product-saved')]
    public function updateProductList() {}

    public function toggleActiveInactive(Product $product)
    {
        $product->is_active = ! $product->is_active;
        $product->save();
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
    }

    public function clearFilters()
    {
        $this->clearStatusFilters();
        $this->clearCategoryFilters();
    }

    public function clearStatusFilters()
    {
        $this->status_filters = [];
    }

    public function clearCategoryFilters()
    {
        $this->category_filters = [];
    }

    public function sort($column) {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        return view('livewire.products.product-list',
            ['products' => Product::with('category:id,name')
                ->search($this->search)
                ->statusfilter($this->status_filters)
                ->categoryfilter($this->category_filters)
                ->orderBy($this->sortBy, $this->sortDirection)
                ->paginate($this->quantity),
            ]
        );
    }
}
