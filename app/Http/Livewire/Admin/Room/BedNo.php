<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BedNo extends Component
{
    protected $listeners = [
        'OpenRoomBedNoComponent' => 'Open',
    ];

    public function mount($rooms = [])
    {
        $this->rooms = $rooms;
        $this->building_id = session('building_id');
        $this->no_of_beds = 0;
    }

    public function Open($rooms = [])
    {
        $this->mount($rooms);
        $this->dispatchBrowserEvent('OpenRoomBedNoModal');
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $Rooms = Room::buildingId($this->building_id);
            $Rooms = $Rooms->when($this->rooms ?? [], function ($q, $value) {
                return $q->whereIn('id', $value);
            });
            $Rooms = $Rooms->update(['no_of_beds' => $this->no_of_beds]);
            $this->dispatchBrowserEvent('success', ['message' => 'successfully Updated the room(s) Bed No']);
            $this->dispatchBrowserEvent('TableDraw');
            $this->dispatchBrowserEvent('CloseRoomBedNoModal');
            DB::commit();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.room.bed-no');
    }
}
