<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Rentout;
use App\Models\Room;
use App\Models\Views\RoomDateView;
use Carbon\CarbonPeriod;
use Livewire\Component;

class Status extends Component
{
    protected $listeners = [
        'Fetch',
        'Print',
        'MakeitClean',
        'MakeitDirty',
    ];

    public $building_id;

    public $date;

    public $datas;

    public $tableDates;

    public $type;

    public $floor;

    public $hygiene_status;

    public $status;

    public $booking_status;

    public $rooms;

    public function mount()
    {
        $this->building_id = session('building_id');
        $this->date = date('Y-m-d');
        $this->type = '';
        $this->floor = null;
        $this->hygiene_status = null;
        $this->status = null;
        $this->booking_status = null;
        $this->LoadData();
    }

    public function Fetch()
    {
        $this->LoadData();
    }

    public function LoadData()
    {
        $booking_status_ids = [];
        if($this->booking_status) {
            $booking_status_ids = RoomDateView::whereDate('room_date_views.date', $this->date);
            $booking_status_ids = $booking_status_ids->where('room_date_views.status', $this->booking_status);
            $booking_status_ids = $booking_status_ids->pluck('room_id', 'room_id')->toArray();
        }
        $room = new Room;
        $room = $room->buildingId($this->building_id);
        $room = $room->type($this->type);
        $room = $room->floor($this->floor);
        $room = $room->hygieneStatus($this->hygiene_status);
        $room = $room->status($this->status);
        if($this->booking_status) {
            $room = $room->whereIn('id', $booking_status_ids);
        }
        $this->rooms = [];
        $this->rooms = $room->orderBy('floor');
        $this->rooms = $room->get();
        $this->tableDates();
        $this->tableContent();
    }

    public function tableDates()
    {
        $this->tableDates = CarbonPeriod::since($this->date)->days(1)->until($this->date)->toArray();
        foreach ($this->tableDates as $key => $value) {
            $this->tableDates[$key] = $value->format('Y-m-d');
        }
    }

    public function MakeitClean()
    {
        $ids = $this->rooms->pluck('id')->toArray();
        Room::whereIn('id', $ids)->update(['hygiene_status' => Room::Clean]);
        $this->LoadData();
    }

    public function MakeitDirty()
    {
        $ids = $this->rooms->pluck('id')->toArray();
        Room::whereIn('id', $ids)->update(['hygiene_status' => Room::Dirty]);
        $this->LoadData();
    }

    public function tableContent()
    {
        $this->datas = [];
        foreach ($this->rooms as $key => $value) {
            $RoomStatus = RoomDateView::whereDate('date', $this->date)->whereNotIn('status', [Rentout::Cancelled, Rentout::CheckOut])->where('room_id', $value->id)->value('status') ?? Room::Vacant;
            $single['id'] = $value->id;
            $single['room_no'] = $value->room_no;
            $single['type'] = $value->type;
            $single['floor'] = $value->floor;
            $single['hygiene_status'] = $value->hygiene_status;
            $single['booking_status'] = $RoomStatus;
            $single['status'] = $value->status;
            $this->datas[] = $single;
        }
    }

    public function ViewModal($id)
    {
        $this->emit('RoomViewModal', $id, $this->date);
    }

    public function Print()
    {
        return redirect()->route('Building::Room::Status::Print', ['tableDates' => $this->tableDates, 'tableContent' => $this->datas])->with(['hi' => 'hello word']);
    }

    public function render()
    {
        return view('livewire.admin.room.status');
    }
}
