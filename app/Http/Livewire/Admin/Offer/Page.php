<?php

namespace App\Http\Livewire\Admin\Offer;

use App\Models\Offer;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Page extends Component
{
    protected $rules = [
        'offers.amount' => ['required'],
        'offers.start_date' => ['required'],
        'offers.end_date' => ['required'],
    ];

    protected $messages = [
        'offers.amount' => 'The amount field is required',
        'offers.start_date' => 'The start date field is required',
        'offers.end_date' => 'The end date field is required',
    ];

    public $offers;

    public function mount()
    {
        $this->offers = [
            'building_id' => session('building_id'),
            'status' => 'Active',
            'amount' => '100',
            'start_date' => date('Y-m-d'),
            'end_date' => date('Y-m-d'),
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $model = new Offer;
            $response = $model->selfCreate($this->offers);
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
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
        return view('livewire.admin.offer.page');
    }
}
