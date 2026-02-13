<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateEditCategory extends Component
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

        $this->modal('create-edit-category')->show();
    }

    public function updatedName()
    {
        $this->slug = $this->slug ?? Str::slug($this->name);
    }

    public function saveCategory()
    {
        $this->slug = Str::trim($this->slug);

        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->category_id),
            ],
            'description' => 'nullable|string',
        ]);

        // if ($this->category_id)
        //     $category = Category::find($this->category_id);
        // else
        //     $category = new Category();

        $category = Category::findOrNew($this->category_id);
        $category->name = $this->name;
        $category->slug = $this->slug;
        $category->description = $this->description;
        $category->save();

        $this->dispatch('category-saved');

        $this->modal('create-edit-category')->close();
        $this->close();
    }

    public function close()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.create-edit-category');
    }
}
