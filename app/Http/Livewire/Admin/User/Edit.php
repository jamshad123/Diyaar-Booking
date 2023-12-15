<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public function mount($user_id)
    {
        $this->User = User::find($user_id);
        $this->users = $this->User->toArray();
    }

    protected function rules($id = null)
    {
        return User::rules($id);
    }

    public function save()
    {
        $this->validate($this->rules($this->User->id));
        try {
            $this->User->update($this->users);
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully updated the password']);
            $this->emit('UserViewComponent');
            $this->dispatchBrowserEvent('CloseUserEditModel');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.user.edit');
    }
}
