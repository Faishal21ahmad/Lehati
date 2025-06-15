<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => 'Category'])]
class CategoryPage extends Component
{
    public $categories = [];

    protected $listeners = [
        'refreshCategories' => 'refreshCategories',
    ];

    public function mount()
    {
        $this->loadCategories();
    }

    public function refreshCategories()
    {
        $this->loadCategories();
    }

    private function loadCategories()
    {
        $this->categories = Category::latest()->get();
    }

    public function deleteCategory($categoryId)
    {
        $category = Category::find($categoryId);
        if ($category) {
            $category->delete();
            $this->dispatch(
                'showToast',
                message: __('Category deleted successfully.'),
                type: 'success',
                duration: 5000
            );
            
        } else {
            $this->dispatch(
                'showToast',
                message: __('Category not found.'),
                type: 'error',
                duration: 5000
            );
        }
        $this->refreshCategories();
    }

    public function render()
    {
        return view('livewire.category.category-page');
    }
}
