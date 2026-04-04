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

    public array $filters = [];

    public array $selected = [];
    public $selectAll = false;
    public $pageCategoryIds = [];

    #[On('category-saved')]
    public function updateCategoryList() {}

    // * select all item feature start
    public function updatedSelectAll($checked)
    {
        $this->selected = $checked ? $this->pageCategoryIds : [];
    }
    public function updatedSelected()
    {
        $this->selectAll = ! empty($this->pageCategoryIds) && count(array_intersect($this->selected, $this->pageCategoryIds)) === count($this->pageCategoryIds);
    }
    public function updatingPage($page)
    {
        $this->selectAll = false;
        $this->selected = [];
    }
    public function deleteSelected()
    {
        $ids = array_intersect($this->selected, $this->pageCategoryIds);

        Category::whereIn('id', $ids)->delete();

        $this->selected = array_diff($this->selected, $ids);
        $this->selectAll = false;

        $this->dispatch('toast-fire', type: 'success', message: 'Selected categories deleted!');
    }
    // * select all item feature end


    //* individually category status change
    public function toggleActiveInactive(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();
        $this->dispatch('toast-fire', type: 'success', message: 'Status changed successfully!');
    }

    //* individually category delete
    public function deleteCategory(Category $category)
    {
        $category->delete();
        $this->dispatch('toast-fire', type: 'success', message: 'Category deleted successfully');
    }

    public function actionForAll($action = 'delete')
    {
        if ($action == 'delete') {
            $this->deleteSelected();
        } 
        elseif ($action == 'active') {
            Category::whereIn('id', $this->selected)->update(['is_active' => true]);
            $this->dispatch('toast-fire', type: 'success', message: 'Status changed successfully!');
        } 
        elseif ($action == 'inactive') {
            Category::whereIn('id', $this->selected)->update(['is_active' => false]);
            $this->dispatch('toast-fire', type: 'success', message: 'Status changed successfully!');
        }
    }

    public function clearFilters()
    {
        $this->filters = [];
    }

    public function render()
    {
        $categories = Category::search($this->search)
                    ->filter($this->filters)
                    ->latest('updated_at')
                    ->paginate($this->quantity);

        // Store current page IDs
        $this->pageCategoryIds = $categories->pluck('id')->toArray();

        return view('livewire.category-list')->with('categories', $categories);
    }
}
