<?php

namespace App\Http\Livewire\Admin\Room;

use App\Models\Rentout;
use App\Models\Room;
use App\Models\Views\RoomDateView;
use Carbon\CarbonPeriod;
use Livewire\Component;

class TableStatus extends Component
{
    protected $listeners = ['Fetch' => 'LoadData'];

    public $building_id;

    public $from_date;

    public $to_date;

    public $type;

    public $floor;

    public $hygiene_status;

    public $status;

    public $booking_status;

    public $rooms = [];

    public $tableDates;

    public $tableContent;

    public function mount()
    {
        $this->building_id = session('building_id');
        $this->from_date = date('Y-m-d', strtotime('-6 days'));
        $this->to_date = date('Y-m-d');
        $this->type = '';
        $this->floor = null;
        $this->hygiene_status = null;
        $this->status = null;
        $this->booking_status = null;
        $this->LoadData();
    }

    public function LoadData()
    {
        $booking_status_ids = [];
        if($this->booking_status) {
            $booking_status_ids = RoomDateView::whereBetween('room_date_views.date', [$this->from_date, $this->to_date]);
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
        // $room = $room->limit(100);
        $room = $room->orderBy('floor');
        $this->rooms = $room->get();
        $this->tableDatesFunction();
        $this->tableContentFunction();
    }

    public function tableDatesFunction()
    {
        $this->tableDates = CarbonPeriod::since($this->from_date)->days(1)->until($this->to_date)->toArray();
        foreach ($this->tableDates as $key => $value) {
            $this->tableDates[$key] = $value->format('Y-m-d');
        }
    }

    public function tableContentFunction()
    {
        $this->tableContent = [];
        foreach ($this->rooms as$value) {
            foreach ($this->tableDates as $date) {
                $date = date('Y-m-d', strtotime($date));
                $single['dates'][$date] = '<td></td>';
            }
            $single['room_no'] = $value->room_no;
            $single['type'] = $value->type;
            $single['floor'] = $value->floor;
            $single['hygiene_status'] = $value->hygiene_status;
            $single['status'] = $value->status;
            $RoomDateViews = RoomDateView::where('room_id', $value->id)->whereBetween('date', [$this->from_date, $this->to_date])->orderBy('rentout_id')->select('rentout_id', 'date', 'status')->get();
            $rentout_ids = $RoomDateViews->pluck('rentout_id', 'rentout_id')->toArray();
            if(! empty($rentout_ids)) {
                $Rentouts = Rentout::whereIn('id', $rentout_ids)->get();
                foreach ($Rentouts as $Rentout) {
                    foreach ($this->tableDates as $date) {
                        $date = date('Y-m-d', strtotime($date));
                        $single['dates'][$date] = '<td></td>';
                    }
                    $dates = $Rentout->roomDates()->where('room_id', $value->id)->whereBetween('date', [$this->from_date, $this->to_date])->pluck('date')->toArray();
                    $first_date = date('Y-m-d', strtotime($dates[0]));
                    $name = $Rentout->customer->full_name;
                    $colspan = count($dates);
                    $status = $Rentout->status;
                    switch ($status) {
                        case Rentout::Booked:
                        $class_name = 'bg-label-primary';
                        break;
                        case Rentout::CheckIn:
                        $class_name = 'bg-label-warning';
                        break;
                        case Rentout::CheckOut:
                        $class_name = 'bg-label-success';
                        break;
                        case Rentout::Cancelled:
                        $class_name = 'bg-label-secondary';
                        break;
                        default:
                        $class_name = 'bg-label-primary';
                        break;
                    }
                    $title = "<span class='$class_name mb-1'>$status : $name</span>";
                    $single['dates'][$first_date] = "<td class='".$class_name."' style='width:100%' align='center' colspan='$colspan'>$title</td>";
                    foreach ($dates as $days => $date) {
                        if ($days) {
                            $date = date('Y-m-d', strtotime($date));
                            if(isset($single['dates'][$date])) {
                                if($single['dates'][$date] == '<td></td>') {
                                    $single['dates'][$date] = '<td style="display: none"></td>';
                                }
                            }
                        }
                    }
                    $this->tableContent[] = $single;
                }
            } else {
                $this->tableContent[] = $single;
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.room.table_status');
    }
}
