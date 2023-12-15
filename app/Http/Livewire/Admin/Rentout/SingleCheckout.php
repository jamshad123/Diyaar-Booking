<?php

namespace App\Http\Livewire\Admin\Rentout;

use App\Models\Checkout;
use App\Models\CheckoutPayment;
use App\Models\Rentout;
use App\Models\RentoutRoom;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SingleCheckout extends Component
{
    public $SelectedRooms;

    public $checkouts;

    public $tax_percentage;

    public $payments;

    public $payment;

    public $rentout;

    public $rentout_id;

    public $rentout_ids = [];

    public $SelectedRentouts;

    public $checkout_id;

    public function mount($rentout_id = null)
    {
        $this->rentout = Rentout::find($rentout_id);
        if (! $this->rentout) {
            return redirect(route('Rentout::List'));
        }
        $this->tax_percentage = Settings::where('key', 'tax_percentage')->value('values') ?? 0;
        $this->rentout_id = $rentout_id;
        $this->rentout_ids[] = $rentout_id;
        $this->payments = [];
        $this->payment = [
            'payment_mode' => CheckoutPayment::Direct,
            'amount' => 0,
        ];
        $this->checkouts = [
            'rentout_id' => $this->rentout_id,
            'customer_id' => $this->rentout->customer_id,
            'total' => $this->rentout->total,
            'extra_bed_charge' => $this->rentout->extra_bed_charge,
            'tax' => $this->rentout->tax,
            'security_deposit' => $this->rentout->security_amount,
            'security_deposit_payment_mode' => 'Direct Payment',
            'security_amount' => 0,
            'security_reason' => '',
            'booking_discount_amount' => $this->rentout->discount_amount,
            'special_discount_amount' => 0,
            'special_discount_reason' => '',
            'additional_charges' => 0,
            'additional_charge_comments' => '',
            'payment_mode' => 'Direct Payment',
            'grand_total' => 0,
            'advance_amount' => $this->rentout->advance_amount,
            'paid' => 0,
            'balance' => 0,
        ];
        $this->SelectedRooms = RentoutRoom::where('rentout_id', $this->rentout_id)->get();
        $this->SelectedRentouts = Rentout::where('id', $this->rentout_id)->get();
        $this->calculator();
    }

    public function updated($key, $value)
    {
        if(in_array($key, ['checkouts.additional_charges', 'checkouts.special_discount_amount'])) {
            $this->calculator();
        }
        if ($key == 'checkouts.special_discount_amount') {
            if($value == '') {
                $this->checkouts['special_discount_amount'] = 0;
            }
        }
        if ($key == 'checkouts.additional_charges') {
            if($value == '') {
                $this->checkouts['additional_charges'] = 0;
            }
        }
    }

    public function AddPayment()
    {
        try {
            if($this->payment['amount'] <= 0) throw new \Exception('Please enter any amount', 1);
            $this->payments[] = $this->payment;
            $this->payment['amount'] = 0;
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully added payment']);
            $this->calculator();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function calculator()
    {
        $tax = $extra_bed_charge = 0;
        $total = $grand_total = $this->SelectedRooms->sum('total');
        if($this->SelectedRentouts) {
            $extra_bed_charge = $this->SelectedRentouts->sum('extra_bed_charge');
            $this->checkouts['security_deposit'] = $this->SelectedRentouts->sum('security_amount');
        }
        $total += $extra_bed_charge;
        $tax = $total * $this->tax_percentage / 100;
        $this->checkouts['extra_bed_charge'] = $extra_bed_charge;
        $this->checkouts['total'] = $total;
        $this->checkouts['tax'] = $tax;
        $grand_total = $total + $tax + floatval($this->checkouts['additional_charges']) - floatval($this->checkouts['special_discount_amount']) - $this->checkouts['booking_discount_amount'];
        $this->checkouts['grand_total'] = $grand_total;
        $payable_amount = $this->checkouts['grand_total'] - $this->checkouts['advance_amount'];
        $this->checkouts['paid'] = array_sum(array_column($this->payments, 'amount'));
        $this->checkouts['balance'] = $payable_amount - $this->checkouts['paid'];
    }

    public function RemovePayment($key)
    {
        try {
            DB::beginTransaction();
            if(isset($this->payments[$key]['id'])) {
                $CheckoutPayment = new CheckoutPayment;
                $response = $CheckoutPayment->selfDelete($this->payments[$key]['id']);
                if($response['result'] != 'success') throw new \Exception($response['result'], 1);
            }
            unset($this->payments[$key]);
            $this->calculator();
            DB::commit();
            $this->dispatchBrowserEvent('success', ['message' => 'Successfully deleted the payment']);
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $this->checkouts['rooms'] = $this->SelectedRooms;
            $this->checkouts['rentout_ids'] = $this->rentout_ids;
            $this->checkouts['payments'] = $this->payments;
            $this->checkouts['building_id'] = session('building_id');

            if($this->checkouts['balance'] > 0 && $this->checkouts['paid'] <= 0) {
                throw new \Exception('Please add any payment', 1);
            }
            if($this->checkouts['balance'] < 0) {
                throw new \Exception('Balance Should not be less than 0', 1);
            }
            $Checkout = new Checkout;
            if($this->checkout_id) {
                $response = $Checkout->selfUpdate($this->checkouts, $this->checkout_id);
            } else {
                $response = $Checkout->selfCreate($this->checkouts);
            }
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $this->checkout_id = $response['id'];
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            DB::commit();

            return redirect(route('Rentout::List', Rentout::CheckIn));
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.rentout.single-checkout');
    }
}
