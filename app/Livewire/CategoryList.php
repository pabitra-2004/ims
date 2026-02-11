<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

    public int $quantity = 10;
    public ?string $search = '';
    public array $filters = [];

    #[On('category-created')]
    #[On('category-updated')]
    public function updateCategoryList() {}


    public function toggleActiveInactive(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
    }

    public function clearFilters()
    {
        $this->filters = [];
    }

    public function render()
    {
        return view('livewire.category-list', [
            'categories' => Category::search($this->search)
                ->filter($this->filters)
                ->latest()
                ->paginate($this->quantity),
        ]);
    }
}
