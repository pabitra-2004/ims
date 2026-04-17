<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryList extends Component
{
    use WithPagination;

    /*--------------------------------------------------------------------------
    | properties
    |--------------------------------------------------------------------------*/
    public int $quantity = 10;
    public ?string $search = '';
    public array $filters = [];
    public array $selected = [];
    public $selectAll = false;
    public array $pageCategoryIds = [];

    /*--------------------------------------------------------------------------
    | listeners
    |--------------------------------------------------------------------------*/
    #[On('category-saved')]
    public function updateCategoryList()
    {
        $this->resetPage();
    }

    /*--------------------------------------------------------------------------
    | lifecycle hooks
    |--------------------------------------------------------------------------*/
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function updatingPage($page)
    {
        $this->selectAll = false;
        $this->selected = [];
    }

    /* --------------------------------------------------------------------------
    | selection logic
    |--------------------------------------------------------------------------*/
    public function updatedSelectAll($checked)
    {
        $this->selected = $checked ? $this->pageCategoryIds : [];
    }

    public function updatedSelected()
    {
        $this->selectAll = ! empty($this->pageCategoryIds) && count(array_intersect($this->selected, $this->pageCategoryIds)) === count($this->pageCategoryIds);
    }

    /*--------------------------------------------------------------------------
    | bulk actions
    |--------------------------------------------------------------------------*/
    public function actionForAll($action = 'delete')
    {
        if ($action == 'delete') {
            $this->deleteSelected();
        } 
        elseif ($action == 'active') {
            Category::whereIn('id', $this->selected)->update(['is_active' => true]);
            $this->resetPage();
            $this->dispatch('toast-fire', type: 'success', message: 'Status changed successfully!');
        } 
        elseif ($action == 'inactive') {
            Category::whereIn('id', $this->selected)->update(['is_active' => false]);
            $this->resetPage();
            $this->dispatch('toast-fire', type: 'success', message: 'Status changed successfully!');
        }
    }

    public function deleteSelected()
    {
        $ids = array_intersect($this->selected, $this->pageCategoryIds);
        if (empty($ids)) {
            return;
        }
        Category::whereIn('id', $ids)->delete();

        $this->selected = array_diff($this->selected, $ids);
        $this->selectAll = false;
        $this->resetPage();
        $this->dispatch('toast-fire', type: 'success', message: 'Selected categories deleted!');
    }

    /*--------------------------------------------------------------------------
    | single actions
    |--------------------------------------------------------------------------*/
    public function toggleActiveInactive(Category $category)
    {
        $category->update([
            'is_active' => ! $category->is_active,
        ]);
        $this->resetPage();
        $this->dispatch('toast-fire', type: 'success', message: 'Status changed successfully!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        $this->resetPage();
        $this->dispatch('toast-fire', type: 'success', message: 'Category deleted successfully');
    }

    /*--------------------------------------------------------------------------
    | filters
    |--------------------------------------------------------------------------*/
    public function clearFilters()
    {
        $this->filters = [];
        $this->resetPage();
    }

    /*--------------------------------------------------------------------------
    | render
    |--------------------------------------------------------------------------*/
    public function render()
    {
        $categories = Category::search($this->search)
            ->filter($this->filters)
            ->latest('updated_at')
            ->paginate($this->quantity);

        // store current page IDs
        $this->pageCategoryIds = $categories->pluck('id')->toArray();
        return view('livewire.categories.category-list')->with('categories', $categories);
    }
}
