<?php

namespace App\Http\Livewire\Admin\Coupon;

use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    protected $rules = [
        'coupons.amount' => ['required'],
        'coupons.no_of_coupon' => ['required'],
        'coupons.expiry_at' => ['required'],
    ];

    protected $messages = [
        'coupons.amount' => 'The coupons amount field is required',
        'coupons.no_of_coupon' => 'Please Mention no of the coupons',
        'coupons.expiry_at' => 'Please Mention expiry at coupons',
    ];

    public $coupons;

    public function mount()
    {
        $this->coupons = [
            'code' => Str::random(10),
            'amount' => '100',
            'no_of_coupon' => '1',
            'expiry_at' => date('Y-m-d', strtotime('+1 week')),
            'created_by' => auth()->user()->id,
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $model = new Coupon;
            for($i = 0; $i < $this->coupons['no_of_coupon']; $i++) {
                $response = $model->selfCreate($this->coupons);
                if (! $response['result']) {
                    throw new \Exception($response['message'], 1);
                }
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
        return view('livewire.admin.coupon.create');
    }
}
