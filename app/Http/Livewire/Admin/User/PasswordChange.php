<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Hash;
use Livewire\Component;

class PasswordChange extends Component
{
    public function mount($user_id)
    {
        $this->user_id = $user_id;
        $this->password = '';
        $this->password_confirmation = '';
        $this->User = User::find($user_id);
    }

    protected $rules = [
        'password' => 'required|min:6',
        'password_confirmation' => 'required|same:password',
    ];

    public function save()
    {
        $this->validate();
        try {
            $this->User->password = Hash::make($this->password);
            $this->User->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully updated the password']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.user.password-change');
    }
}
