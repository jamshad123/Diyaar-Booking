<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\DailyCollection;
use App\Models\Views\JournalView;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dayclose extends Component
{
    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->table_id = '';
        $this->DailyCollection = DailyCollection::where('user_id', '=', $this->user_id)->whereBetween('opening_time', [date('Y-m-d 0:0:0'), now()])->first();
        if($this->DailyCollection) {
            $this->table_id = $this->DailyCollection->id;
            $this->daily_collections = $this->DailyCollection->toArray();
        } else {
            $this->daily_collections = [
                'closing_balance' => 0,
                'closing_note' => '',
                'opening_time' => now(),
            ];
        }

        $this->paymentsData = [];
        $this->payments();
    }

    public function payments()
    {
        $this->paymentsData = [];
        $paymentModeOptions = paymentModeOptions();
        foreach($paymentModeOptions as $payment_mode => $value) {
            $this->paymentsData[$payment_mode] = 0;
        }
        foreach($paymentModeOptions as $payment_mode => $value) {
            if($this->DailyCollection) {
                $this->paymentsData[$payment_mode] += JournalView::where('created_by', auth()->user()->id)->whereBetween('created_at', [$this->DailyCollection->opening_time, now()])->where('payment_mode', $payment_mode)->sum('amount');
            }
        }
    }

    protected $rules = [
        'daily_collections.closing_balance' => ['required'],
    ];

    protected $messages = [
        'daily_collections.closing_balance' => 'The Closing Balance field is required',
    ];

    public function save()
    {
        $this->validate();
        try {
            if(! $this->table_id) throw new \Exception('Please Add Opening Balance First', 1);
            DB::beginTransaction();
            $DailyCollection = new DailyCollection;
            $response = $DailyCollection->selfUpdate($this->daily_collections, $this->table_id);
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            $this->mount();
            DB::commit();
            $this->dispatchBrowserEvent('CloseDayCloseModal');

            return redirect(route('Building::List'));
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dayclose');
    }
}
