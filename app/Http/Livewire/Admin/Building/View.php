<?php

namespace App\Http\Livewire\Admin\Building;

use App\Models\Building;
use Livewire\Component;

class View extends Component
{
    protected $listeners = [
        'BuildingViewComponent' => 'refreshComponent',
    ];

    public function refreshComponent()
    {
        $this->mount($this->building_id);
    }

    public function mount($id)
    {
        $this->building_id = $id;
        $this->Building = Building::find($id);
        $this->buildings = $this->Building->toArray();
    }

    public function render()
    {
        return view('livewire.admin.building.view');
    }
}
