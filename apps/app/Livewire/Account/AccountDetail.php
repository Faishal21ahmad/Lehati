<?php

namespace App\Livewire\Account;

use App\Models\User;
use App\Models\UserData;
use GuzzleHttp\Promise\Create;
use Livewire\Component;
use Livewire\Attributes\Layout;
use phpDocumentor\Reflection\Types\This;

#[Layout('components.layouts.app', ['title' => "Account"])]
class AccountDetail extends Component
{
    public $account, $codeUser, $name, $email, $role, $verified, $status;
    public $userdata, $phone, $address, $nik, $gender;

    public function mount($usercode = null)
    {
        if ($usercode) {
            $this->account = User::where('code_user', $usercode)->first();
            if (!$this->account) {
                abort(404, 'Account not found');
            }
        } else {
            abort(404, 'No user code provided');
        }
        // $this->userdata = UserData::where('user_id', $this->account->id)->first();

        $this->codeUser = $this->account->code_user;
        $this->name = $this->account->name;
        $this->email = $this->account->email;
        $this->role = $this->account->role;
        $this->verified = $this->account->email_verified_at;
        $this->status = $this->account->is_active;

        $this->phone = $this->account->userdata->phone ?? '';
        $this->address = $this->account->userdata->address ?? '';
        $this->nik = $this->account->userdata->nik ?? '';
        $this->gender = $this->account->userdata->gender ?? '';
    }

    public function updateAccount()
    {
        try {
            User::updateOrCreate(
                ['id' => $this->account->id],
                [
                    'code_user' => $this->codeUser,
                    'name' => $this->name,
                    'email' => $this->email,
                    'role' => $this->role,
                    'is_active' => $this->status,
                ]
            );

            $this->dispatch(
                'showToast',
                message: __('Account updated successfully!'),
                type: 'success',
                duration: 5000
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'showToast',
                message: __('Failed to update account: ') . $e->getMessage(),
                type: 'danger',
                duration: 5000
            );
            return;
        }
    }

    public function updateDataAccount() {
        try { 
            UserData::updateOrCreate(
                ['user_id' => $this->account->id],
                [
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'nik' => $this->nik,
                    'gender' => $this->gender,
                ]
            );

            $this->dispatch(
                'showToast',
                message: __('User data updated successfully!'),
                type: 'success',
                duration: 5000
            );  

        } catch (\Exception $e) {
            $this->dispatch(
                'showToast',
                message: __('Failed to update user data: ') . $e->getMessage(),
                type: 'danger',
                duration: 5000
            );
            return;
        }
    }


    public function render()
    {
        return view('livewire.account.account-detail');
    }
}
