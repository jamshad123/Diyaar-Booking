<?php

namespace App\Http\Livewire\Admin\Rentout;

use App\Models\CheckoutPayment;
use App\Models\Rentout;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BalancePayment extends Component
{
    public $rentout_id;

    public $checkin;

    public $rentout;

    public $payments;

    public $payment;

    public function mount($rentout_id)
    {
        $this->rentout_id = $rentout_id;
        $this->rentout = Rentout::find($rentout_id);
        if (! $this->rentout) {
            return redirect(route('Rentout::List'));
        }
        $this->payments = [];
        $this->payment = [
            'payment_mode' => CheckoutPayment::Direct,
            'amount' => 0,
        ];
    }

    public function AddPayment()
    {
        try {
            DB::beginTransaction();
            if($this->payment['amount'] <= 0) throw new \Exception('Please enter any amount', 1);
            $this->payments[] = $this->payment;
            $this->payment['amount'] = 0;
            DB::commit();
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully added payment']);
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function RemovePayment($key)
    {
        unset($this->payments[$key]);
    }

    public function save()
    {
        try {
            $paymentData['checkout_id'] = $this->rentout->checkout->id;
            $CheckoutPayment = new CheckoutPayment;
            foreach ($this->payments as $key => $value) {
                $paymentData['amount'] = $value['amount'];
                $paymentData['payment_mode'] = $value['payment_mode'];
                $response = $CheckoutPayment->selfCreate($paymentData);
                if (! $response['result']) {
                    throw new \Exception($response['message'], 1);
                }
            }
            $this->emit('RefreshViewComponent');
            $this->mount($this->rentout_id);
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully added payment']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.rentout.balance-payment');
    }
}
