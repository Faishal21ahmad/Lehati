<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app', ['title' => "Dashboard"])]
class DashboardPage extends Component
{
    public function render()
    {
        

        return view('livewire.dashboard.dashboard-page');
    }
}
