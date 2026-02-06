<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

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
            'categories' => Category::paginate(10),
        ]);
    }
}
