<?php

namespace App\Http\Livewire\Admin\Rentout;

use App\Models\Checkout as CheckoutModel;
use App\Models\CheckoutPayment;
use App\Models\Rentout;
use App\Models\RentoutRoom;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    public $rentout_ids;

    public $RentoutRooms;

    public $checkouts;

    public $SelectedRooms;

    public $SelectedRentouts;

    public $Customer;

    public $payments;

    public $payment;

    public $tax_percentage;

    public $checkout_id;

    public $PaymentModes;

    public function mount($checkout_id = null)
    {
        $this->tax_percentage = Settings::where('key', 'tax_percentage')->value('values') ?? 0;
        $this->checkout_id = $checkout_id;
        $this->RentoutRooms = RentoutRoom::checkIn()->currentBuilding();
        $this->RentoutRooms = $this->RentoutRooms->join('rooms', 'rooms.id', 'rentout_rooms.room_id');
        $this->RentoutRooms = $this->RentoutRooms->join('customers', 'customers.id', 'rentout_rooms.customer_id');
        $this->RentoutRooms = $this->RentoutRooms->select(DB::raw('CONCAT(GROUP_CONCAT(room_no)," - ",IFNULL(customers.first_name,"")," ",IFNULL(customers.last_name,"")) as name'), 'rentout_rooms.rentout_id');
        $this->RentoutRooms = $this->RentoutRooms->groupBy('rentout_id', 'customer_id');
        $this->RentoutRooms = $this->RentoutRooms->pluck('name', 'rentout_id');
        $this->RentoutRooms = $this->RentoutRooms->toArray();
        $this->SelectedRooms = [];
        $this->SelectedRentouts = [];
        $this->Customer = [];
        $this->payments = [];
        $this->payment = [
            'payment_mode' => CheckoutPayment::Direct,
            'amount' => 0,
        ];
        $this->PaymentModes = paymentModeOptions();
        $this->loadData();
    }

    public function loadData()
    {
        if($this->checkout_id) {
            $CheckoutModel = CheckoutModel::find($this->checkout_id);
            $this->checkouts = $CheckoutModel->toArray();
            $this->rentout_ids = $CheckoutModel->rentouts()->pluck('id', 'id')->toArray();
            $this->SelectedRentouts = Rentout::whereIn('id', $this->rentout_ids)->get();
            $this->SelectedRooms = RentoutRoom::whereIn('rentout_id', $this->rentout_ids)->get();
            $this->payments = $CheckoutModel->payments->toArray();
            $this->getBillingCustomer();
        } else {
            $this->checkouts = [
                'rentout_id' => '',
                'customer_id' => '',
                'total' => 0,
                'tax' => 0,
                'security_deposit' => 0,
                'security_deposit_payment_mode' => 'Direct Payment',
                'security_amount' => 0,
                'security_reason' => '',
                'booking_discount_amount' => 0,
                'special_discount_amount' => 0,
                'special_discount_reason' => '',
                'additional_charges' => 0,
                'additional_charge_comments' => '',
                'payment_mode' => 'Direct Payment',
                'grand_total' => 0,
                'advance_amount' => 0,
                'paid' => 0,
                'balance' => 0,
            ];
        }
        $this->calculator();
    }

    public function get()
    {
        if(! $this->rentout_ids) {
            return false;
        }
        $this->checkouts['rentout_id'] = '';
        $this->SelectedRentouts = Rentout::whereIn('id', $this->rentout_ids)->get();
        $this->SelectedRooms = RentoutRoom::whereIn('rentout_id', $this->rentout_ids)->get();
        if($this->SelectedRentouts) {
            $this->checkouts['rentout_id'] = $this->SelectedRentouts[0]['id'];
            $this->getBillingCustomer();
        }
        $this->checkouts['advance_amount'] = $this->SelectedRentouts->sum('advance_amount');
        $this->checkouts['booking_discount_amount'] = $this->SelectedRentouts->sum('discount_amount');
        $this->calculator();
    }

    public function updated($key, $value)
    {
        if(in_array($key, ['checkouts.additional_charges', 'checkouts.special_discount_amount'])) {
            $this->calculator();
        }
        if(in_array($key, ['checkouts.rentout_id'])) {
            $this->getBillingCustomer();
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

    public function getBillingCustomer()
    {
        $this->Customer = Rentout::find($this->checkouts['rentout_id']);
        $this->checkouts['customer_id'] = $this->Customer['customer_id'];
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
        $total = $tax = $grand_total = $extra_bed_charge = 0;
        foreach ($this->SelectedRooms as $value) {
            $rent = $value->roomDates->sum('amount');
            $total += $rent;
            $grand_total += $rent;
        }
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
            if($this->checkouts['paid'] <= 0) {
                throw new \Exception('Please add any payment', 1);
            }
            $Checkout = new CheckoutModel;
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

            return redirect(route('Rentout::checkout::edit', $this->checkout_id));
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.rentout.checkout');
    }
}
