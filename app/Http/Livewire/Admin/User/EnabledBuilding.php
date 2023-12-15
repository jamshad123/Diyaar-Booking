<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\Building;
use App\Models\UserBuilding;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EnabledBuilding extends Component
{
    public $user_id;

    public $buildingList;

    public $user_buildings;

    public function mount($user_id)
    {
        $this->user_id = $user_id;
        $this->buildingList = Building::pluck('name', 'id')->toArray();
        $this->user_buildings = UserBuilding::where('user_id', $this->user_id)->pluck('building_id')->toArray();
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $UserBuilding = new UserBuilding;
            UserBuilding::where('user_id', $this->user_id)->delete();
            if(! $this->user_buildings) {
                throw new \Exception('Please Add Any Building', 1);
            }
            foreach ($this->user_buildings as $building_id) {
                $data['user_id'] = $this->user_id;
                $data['building_id'] = $building_id;
                $response = $UserBuilding->selfCreate($data);
                if(! $response['result']) throw new \Exception($response['message'], 1);
            }
            $this->dispatchBrowserEvent('success', ['message' => $response['message']]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.admin.user.enabled-building');
    }
}
