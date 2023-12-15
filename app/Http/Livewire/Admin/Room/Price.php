<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Price extends Component
{
    protected $listeners = [
        'OpenRoomPriceComponent' => 'Open',
    ];

    public function mount($rooms = [])
    {
        $this->rooms = $rooms;
        $this->building_id = session('building_id');
        $this->price = 0;
    }

    public function Open($rooms = [])
    {
        $this->mount($rooms);
        $this->dispatchBrowserEvent('OpenRoomPriceModal');
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $Rooms = Room::buildingId($this->building_id);
            $Rooms = $Rooms->when($this->rooms ?? [], function ($q, $value) {
                return $q->whereIn('id', $value);
            });
            $Rooms = $Rooms->update(['amount' => $this->price]);
            $this->dispatchBrowserEvent('success', ['message' => 'successfully Updated the room(s) price']);
            $this->dispatchBrowserEvent('TableDraw');
            $this->dispatchBrowserEvent('CloseRoomPriceModal');
            DB::commit();
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => $e->getMessage()]);
            DB::rollback();
        }
    }

    public function render()
    {
        return view('livewire.admin.room.price');
    }
}
