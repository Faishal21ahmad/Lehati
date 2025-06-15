<?php

namespace App\Livewire\Category;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\On;

class CategoryModal extends Component
{
    public $isOpen = false;
    public $categoryId = null;
    public $category_name = '';

    protected $rules = [
        'category_name' => 'required|min:3|max:255'
    ];

    #[On('openCategoryModal')]
    public function openModal($categoryId = null)
    {
        $this->resetValidation();
        $this->reset('category_name', 'categoryId');

        if ($categoryId) {
            $category = Category::find($categoryId);
            $this->categoryId = $categoryId;
            $this->category_name = $category->category_name;
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function save()
    {
        $this->validate();

        if ($this->categoryId) {
            // Update
            Category::find($this->categoryId)->update([
                'category_name' => $this->category_name
            ]);
            $this->dispatch(
                'showToast',
                message: __('Category updated successfully.'),
                type: 'success',
                duration: 5000
            );
        } else {
            // Create
            Category::create([
                'category_name' => $this->category_name
            ]);
            $this->dispatch(
                'showToast',
                message: __('Category created successfully.'),
                type: 'success',
                duration: 5000
            );
        }

        $this->closeModal();
        $this->dispatch('refreshCategories');
    }


    public function render()
    {
        return view('livewire.category.category-modal');
    }
}
