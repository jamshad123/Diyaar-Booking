<?php

namespace App\Http\Livewire\Admin\Rentout;

use App\Models\Rentout;
use Livewire\Component;

class Pending extends Component
{
    public $rentout_id;

    public $rentout;

    public function mount($rentout_id)
    {
        $this->rentout_id = $rentout_id;
        $this->rentout = Rentout::find($rentout_id);
        if (! $this->rentout) {
            return redirect(route('Rentout::List'));
        }
    }

    public function statusChange($status)
    {
        if($status == Rentout::Approved) {
            if(! $this->rentout->registration_no) {
                $this->rentout->registration_no = Rentout::GetRegistrationNo();
            }
            $this->rentout->status = Rentout::Booked;
        } else {
            $this->rentout->status = $status;
        }
        $this->rentout->flag = $status;
        $this->rentout->save();
        $this->mount($this->rentout_id);
        $this->emit('RefreshViewComponent');
        $this->dispatchBrowserEvent('success', ['message' => 'Successfully Updated']);
    }

    public function render()
    {
        return view('livewire.admin.rentout.pending');
    }
}
