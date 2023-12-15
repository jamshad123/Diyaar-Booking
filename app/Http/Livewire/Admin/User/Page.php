<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Page extends Component
{
    protected $rules = [
        'users.name' => ['required'],
        'users.email' => ['required', 'unique:users'],
        'users.password' => ['required', 'confirmed'],
    ];

    protected $messages = [
        'users.name' => 'The users Name field is required',
        'users.email.required' => 'The users email field is required',
        'users.email.email' => 'The users email should be a valid email address',
        'users.password.required' => 'The users password field is required',
        'users.password.confirmed' => 'Please Confirm Password',
    ];

    public $users;

    public function mount()
    {
        $this->users = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $model = new User;
            $response = $model->selfCreate($this->users);
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            $this->dispatchBrowserEvent('TableDraw');
            $this->mount();
            DB::commit();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.user.page');
    }
}
