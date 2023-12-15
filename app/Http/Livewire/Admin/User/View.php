<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;

class View extends Component
{
    protected $listeners = [
        'UserViewComponent' => 'refreshComponent',
        'FlagChange',
    ];

    public function refreshComponent()
    {
        $this->mount($this->user_id);
    }

    public function mount($user_id)
    {
        $this->user_id = $user_id;
        $this->User = User::find($user_id);
    }

    public function FlagChange()
    {
        try {
            $this->User->flag = ($this->User->flag == User::Active) ? User::Suspended : User::Active;
            $this->User->save();
            if($this->User->flag == User::Active) {
                $title = 'Activated';
                $text = 'User has been Activated';
            } else {
                $title = 'Suspended!';
                $text = 'User has been suspended';
            }
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'title' => $title,
                'text' => $text,
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.user.view');
    }
}
