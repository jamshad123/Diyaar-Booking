<?php

namespace App\Http\Livewire\Admin\Building\View;

use App\Models\Building;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UpdateTab extends Component
{
    protected $rules = [
        'buildings.name' => ['required'],
    ];

    protected $messages = [
        'buildings.name' => 'The buildings Name field is required',
    ];

    public function mount($id)
    {
        $this->building_id = $id;
        $this->Building = Building::find($id);
        $this->buildings = $this->Building->toArray();
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $Building = new Building;
            $response = $Building->selfUpdate($this->buildings, $this->building_id);
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            $this->mount($this->building_id);
            $this->emit('BuildingViewComponent');
            DB::commit();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function delete()
    {
        try {
            DB::beginTransaction();
            $Building = new Building;
            $response = $Building->selfDelete($this->building_id);
            if (! $response['result']) {
                throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            DB::commit();

            return redirect(route('Building::List'));
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.building.view.update-tab');
    }
}
