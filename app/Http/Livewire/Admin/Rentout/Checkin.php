<?php

namespace App\Http\Livewire\Admin\Rentout;

use App\Models\Rentout;
use Livewire\Component;

class Checkin extends Component
{
    public $rentout_id;

    public $checkin;

    public $rentout;

    public function mount($rentout_id)
    {
        $this->rentout_id = $rentout_id;
        $this->rentout = Rentout::find($rentout_id);
        if (! $this->rentout) {
            return redirect(route('Rentout::List'));
        }
        $this->checkin = [
            'security_deposit_payment_mode' => $this->rentout->security_deposit_payment_mode,
            'security_amount' => '',
            'advance_amount' => '',
            'payment_mode' => $this->rentout->payment_mode,
            'advance_reason' => $this->rentout->advance_reason,
        ];
    }

    public function save($status)
    {
        try {
            if($this->checkin['security_deposit_payment_mode']) {
                $this->rentout->security_deposit_payment_mode = $this->checkin['security_deposit_payment_mode'];
            }
            if($this->checkin['security_amount']) {
                $this->rentout->security_amount += $this->checkin['security_amount'];
            }
            if($this->checkin['payment_mode']) {
                $this->rentout->payment_mode = $this->checkin['payment_mode'];
            }
            if($this->checkin['advance_amount']) {
                $this->rentout->advance_amount += $this->checkin['advance_amount'];
            }
            if($this->checkin['advance_reason']) {
                $this->rentout->advance_reason = $this->checkin['advance_reason'];
            }
            if($this->rentout->advance_amount > $this->rentout->grand_total) {
                throw new \Exception('Cant Collect More than grand total', 1);
            }
            $this->rentout->status = $status;
            $this->rentout->save();
            $this->mount($this->rentout_id);
            $this->emit('RefreshViewComponent');
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully Updated']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.rentout.checkin');
    }
}
