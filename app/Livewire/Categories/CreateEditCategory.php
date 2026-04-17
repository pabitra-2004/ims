<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateEditCategory extends Component
{
    /*--------------------------------------------------------------------------
    | properties
    |--------------------------------------------------------------------------*/
    #[Locked]
    public $category_id;

    public $name;
    public $slug;
    public $description;

    /*--------------------------------------------------------------------------
    |listeners
    |--------------------------------------------------------------------------*/
    #[On('edit-category')]
    public function loadCategory(Category $category)
    {
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;

        $this->modal('create-edit-category')->show();
    }

    /*--------------------------------------------------------------------------
    |lifecycle hooks
    |--------------------------------------------------------------------------*/
    public function updatedName()
    {
        $this->slug = $this->slug ?? Str::slug($this->name);
    }

    /*--------------------------------------------------------------------------
    | actions (create /update)
    |--------------------------------------------------------------------------*/
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

        // $category = Category::findOrNew($this->category_id);
        // $category->name = $this->name;
        // $category->slug = $this->slug;
        // $category->description = $this->description;
        // $category->save();

        Category::updateOrCreate(
            ['id' => $this->category_id],
            [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
            ]
        );

        $this->dispatch('category-saved');

        $this->modal('create-edit-category')->close();
        $message = $this->category_id ? 'Category update successfully!' : 'Category added successfully!';
        $this->dispatch('toast-fire', type: 'success', message: $message, position: 'bottom-right');
        $this->close();
    }

    /*--------------------------------------------------------------------------
    | reset
    |--------------------------------------------------------------------------*/
    public function close()
    {
        $this->reset();
        $this->resetValidation();
    }

    /*---------------------------------------------------------------------------
    | render
    |--------------------------------------------------------------------------*/
    public function render()
    {
        return view('livewire.categories.create-edit-category');
    }
}
