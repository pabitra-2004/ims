<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

    public int $quantity = 10;
    public ?string $search = '';

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

    public function render()
    {
        return view('livewire.category-list', [
            'categories' => Category::search($this->search)
                ->latest()
                ->paginate($this->quantity),
        ]);
    }
}
