<?php

namespace App\Livewire\Account;

use App\Models\User;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => "Account"])]
class AccountPage extends Component
{
    use WithPagination;

    public $query = '';
    public $isactive = '';

    public function disableAccount($codeUser = null)
    {
        // dd($codeUser);

        // $user = User::where('code_user', $codeUser)->first();
        // if ($user) {
        //     $user->is_active = '0';
        //     $user->save();
        //     $this->dispatch('showToast', message: __('Account disabled successfully!'), type: 'success');
        // } else {
        //     $this->dispatch('showToast', message: __('Account not found!'), type: 'error');
        // }


    }

    public function enableAccount() {}


    public function render()
    {
        $query = trim(strtolower($this->query)); // Normalisasi query input
        $isactive = null;

        // Tentukan nilai filter is_active jika query cocok
        if ($query === 'active') {
            $isactive = 1;
        } elseif ($query === 'inactive') {
            $isactive = 0;
        }

        $accounts = User::when($query, function ($builder) use ($query, $isactive) {
            $builder->where(function ($subQuery) use ($query, $isactive) {
                $subQuery->where('name', 'like', '%' . $query . '%')
                    ->orWhere('code_user', 'like', '%' . $query . '%')
                    ->orWhere('role', 'like', '%' . $query . '%');

                // Jika query adalah active/inactive, tambahkan filter status
                if (!is_null($isactive)) {
                    $subQuery->orWhere('is_active', $isactive);
                }
            });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.account.account-page', [
            'accounts' => $accounts,
        ]);
    }
}
