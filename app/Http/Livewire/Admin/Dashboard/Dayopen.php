<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\DailyCollection;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dayopen extends Component
{
    public $user_id;

public $table_id;

public $daily_collections;

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->table_id = '';
        $DailyCollection = DailyCollection::where('user_id', '=', $this->user_id)->whereBetween('opening_time', [date('Y-m-d 0:0:0'), now()])->first();
        if($DailyCollection) {
            $this->table_id = $DailyCollection->id;
            $this->daily_collections = $DailyCollection->toArray();
        } else {
            $this->daily_collections = [
                'opening_balance' => 0,
                'opening_note' => '',
                'opening_time' => now(),
            ];
        }
    }

    protected $rules = [
        'daily_collections.opening_balance' => ['required'],
    ];

    protected $messages = [
        'daily_collections.opening_balance' => 'The Opening Balance field is required',
    ];

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $DailyCollection = new DailyCollection;
            if ($this->table_id) {
                $response = $DailyCollection->DayOpenUpdate($this->daily_collections, $this->table_id);
            } else {
                $response = $DailyCollection->DayOpenCreate($this->daily_collections);
            }
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            $this->mount();
            DB::commit();
            $this->dispatchBrowserEvent('CloseDayOpenModel');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard.dayopen');
    }
}
