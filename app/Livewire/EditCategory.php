<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class EditCategory extends Component
{
    #[Locked]
    public $category_id;
    public $name;
    public $slug;
    public $description;

    #[On('edit-category')]
    public function loadCategory(Category $category)
    {
        // dd($category);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;

        $this->modal('edit-category')->show();
    }

    public function updateCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            // 'slug' => 'nullable|string|max:255|unique:categories,slug',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->category_id),
            ],
            'description' => 'nullable|string',
        ]);

        $category = Category::find($this->category_id);
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->description = $this->description;
        $category->save();

        $this->dispatch('category-updated');

        $this->modal('edit-category')->close();
        $this->reset();
    }

    public function close()
    {
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.edit-category');
    }
}
