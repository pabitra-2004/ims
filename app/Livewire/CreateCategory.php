<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CreateCategory extends Component
{
    public $name;
    public $slug;
    public $description;

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function saveCategory()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        $category = new Category();
        $category->name = $this->name;
        $category->slug = $this->slug ?? Str::slug($this->name);
        $category->description = $this->description;
        $category->save();

        $this->dispatch('category-created');

        $this->modal('create-category')->close();
        $this->reset(['name', 'slug', 'description']);
    }

    public function render()
    {
        return view('livewire.create-category');
    }
}
