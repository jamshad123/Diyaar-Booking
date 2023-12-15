<?php

namespace App\Http\Livewire\Admin\Building;

use App\Models\Building;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    protected $rules = [
        'buildings.name' => ['required'],
    ];

    protected $messages = [
        'buildings.name' => 'The buildings Name field is required',
    ];

    public function mount()
    {
        $this->buildings = [
            'name' => '',
        ];
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $Building = new Building;
            $response = $Building->selfCreate($this->buildings);
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
        return view('livewire.admin.building.create');
    }
}
