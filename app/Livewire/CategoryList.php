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

    #[On('category-saved')]
    public function updateCategoryList() {}


    public function toggleActiveInactive(Category $category)
    {
        $category->is_active = !$category->is_active;
        $category->save();
        $this->dispatch('toast-fire', type: 'success', message: 'Category status successfully changed!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        $this->dispatch('toast-fire', type: 'success', message: 'Category deleted successfully');
    }

    public function actionForAll($action = 'delete')
    {
        dd($this->selected);

        if ($action == 'delete') {
            Category::whereIn('id', $this->selected)->delete();
            $this->dispatch('toast:fire', type: 'success', message: 'Selected categories deleted', theme: 'dark');
        } elseif ($action == 'active') {
            Category::whereIn('id', $this->selected)->update(['is_active' => true]);
        } elseif ($action == 'inactive') {
            Category::whereIn('id', $this->selected)->update(['is_active' => false]);
        }
    }

    public function select($selected)
    {
        // $_selected = array_map(function ($value) {
        //     return (int)$value;
        // }, explode(', ', $selected));

        // dd($_selected);

        // $this->selected = [1, 2, 15, 12];

        $this->selected = collect($this->selected)->merge(explode(', ', $selected))->all();

        // dd($this->selected);
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
