<?php

namespace App\Http\Livewire\Admin\Room;

use App\Actions\Room\RoomPriceCheckAction;
use App\Models\Rentout;
use App\Models\RentoutRoom;
use App\Models\Room;
use App\Models\Views\RoomDateView;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class ViewModal extends Component
{
    protected $listeners = [
        'RoomViewModal' => 'View',
    ];

    public $room_id;

    public $date;

    public $Room;

    public $rentout_room_id;

    public $RentoutRoom;

    public $rentouts;

    public $rentout_rooms;

    public function mount($room_id = null, $date = null)
    {
        Session::forget('BookRoom');
        $this->room_id = $room_id;
        $this->date = $date;
        $this->Room = Room::find($this->room_id);
        if($this->Room) {
            $this->Room['booking_status'] = Room::Vacant;
        }
        $this->rentout_room_id = RoomDateView::where('room_id', $this->room_id)->whereNotIn('status', [Rentout::Cancelled, Rentout::CheckOut])->where('date', $this->date)->value('id');
        $this->RentoutRoom = [];
        if ($this->rentout_room_id) {
            $this->RentoutRoom = RentoutRoom::find($this->rentout_room_id);
            if($this->RentoutRoom) {
                $this->Room['booking_status'] = $this->RentoutRoom->status;
            }
        }
    }

    public function View($id, $date)
    {
        $this->mount($id, $date);
        $this->dispatchBrowserEvent('OpenRoomViewModal');
    }

    public function BookNow()
    {
        $check_in_date = date('Y-m-d');
        $check_out_date = date('Y-m-d', strtotime('+3 days'));
        $action = new RoomPriceCheckAction;
        $this->rentout_rooms = [];
        $roomIds[] = $this->Room['id'];
        $this->rentout_rooms = $action->execute($this->rentout_rooms, $roomIds, $check_in_date, $check_out_date);
        Session::put('BookRoom', ['rentout_rooms' => $this->rentout_rooms]);

        return redirect()->route('Rentout::create');
    }

    public function ChangeHygieneStatus()
    {
        $Room = Room::find($this->room_id);
        $hygiene_status = ($Room->hygiene_status === Room::Dirty) ? Room::Clean : Room::Dirty;
        Room::where('id', $this->room_id)->update(['hygiene_status' => $hygiene_status]);
        $this->mount($this->room_id, $this->date);
        $this->emit('Fetch');
    }

    public function ChangeMaintenanceStatus()
    {
        $Room = Room::find($this->room_id);
        if($Room->status == Room::Active) {
            $status = Room::Maintenance;
        } elseif($Room->status == Room::Maintenance) {
            $status = Room::InActive;
        }elseif($Room->status == Room::InActive) {
            $status = Room::Active;
        }
        $room = Room::find($this->room_id);
        $status = ($room->status == Room::Maintenance) ? Room::Active : Room::Maintenance;
        Room::where('id', $this->room_id)->update(['status' => $status]);
        $this->mount($this->room_id, $this->date);
        $this->emit('Fetch');
    }

    public function ChangeActiveStatus()
    {
        $room = Room::find($this->room_id);
        $status = ($room->status == Room::InActive) ? Room::Active : Room::InActive;
        Room::where('id', $this->room_id)->update(['status' => $status]);
        $this->mount($this->room_id, $this->date);
        $this->emit('Fetch');
    }

    public function render()
    {
        return view('livewire.admin.room.view-modal');
    }
}
