<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Rentout;
use App\Models\RentoutRoom;
use App\Models\Room;
use App\Models\Views\RoomDateView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;

class BuildingController extends Controller
{
    public function __construct()
    {
        $this->Room = new Room;
        $this->Building = new Building;
    }

    public function List()
    {
        return view('admin.building.list');
    }

    public function DataTable(Request $request)
    {
        $data = $request->all();
        $datas = new Building;
        $datas = $datas->when($data['status_id'] ?? '', function ($q, $value) {
            return $q->where('status_id', $value);
        });

        return Datatables::of($datas)
        ->editColumn('name', function ($value) {
            return "<a href='".route('Building::View', $value->id)."'>$value->name</a>";
        })
        ->addColumn('Occupied', function ($value) {
            return $value->Rooms()->where('status', 'Occupied')->groupBy('status')->count();
        })
        ->addColumn('Vacant', function ($value) {
            return $value->Rooms()->where('status', 'Vacant')->groupBy('status')->count();
        })
        ->addColumn('Booked', function ($value) {
            return $value->Rooms()->where('status', 'Booked')->groupBy('status')->count();
        })
        ->addColumn('Active', function ($value) {
            return $value->Rooms()->where('status', 'Active')->groupBy('status')->count();
        })
        ->addColumn('Maintenance', function ($value) {
            return $value->Rooms()->where('status', 'Maintenance')->groupBy('status')->count();
        })
        ->addIndexColumn()
        ->rawColumns(['name', 'checkbox'])
        ->make(true);
    }

    public function View($id)
    {
        return view('admin.building.view', compact('id'));
    }

    public function GetBuildingDropDownList(Request $request)
    {
        return $this->Building->getDropDownList($request->all());
    }

    public function RoomList()
    {
        return view('admin.building.room.list');
    }

    public function RoomDataTable(Request $request)
    {
        $data = $request->all();
        $datas = Room::with('Building');
        $datas = $datas->when($data['building_id'] ?? '', function ($q, $value) {
            return $q->where('building_id', $value);
        });
        $datas = $datas->when($data['status'] ?? '', function ($q, $value) {
            return $q->where('status', $value);
        });
        $datas = $datas->when($data['type'] ?? '', function ($q, $value) {
            return $q->where('type', $value);
        });
        $datas = $datas->when($data['floor'] ?? '', function ($q, $value) {
            return $q->where('floor', $value);
        });
        $datas = $datas->when($data['hygiene_status'] ?? '', function ($q, $value) {
            return $q->where('hygiene_status', $value);
        });

        return Datatables::of($datas)
        ->addColumn('Building', function ($value) {
            $Building = $value->Building ? $value->Building->name : '';

            return "<a href='".route('Building::View', $value->building_id)."'>".$Building.'</a>';
        })
        ->editColumn('name', function ($value) {
            return "<a href='".route('Building::View', $value->id)."'>$value->name</a>";
        })
        ->addColumn('action', function ($value) {
            $return = '<button table_id="'.$value->id.'" class="btn btn-sm text-primary btn-icon item-edit room_edit"><i class="bx bxs-edit"></i></button>';

            return $return;
        })
        ->addIndexColumn()
        ->rawColumns(['name', 'Building', 'action'])
        ->make(true);
    }

    public function GetRoomDropDownList(Request $request)
    {
        return $this->Room->getDropDownList($request->all());
    }

    public function RoomStatus()
    {
        $floors = Room::buildingId(session('building_id'))->pluck('floor', 'floor')->toArray();

        return view('admin.building.room.status', compact('floors'));
    }

    public function RoomPlan()
    {
        return view('admin.building.room.plan');
    }

    public function RoomPlanData($data)
    {
        $list = [];
        $Room = new Room;
        $Room = $Room->buildingId($data['building_id']);
        $RoomCount = clone $Room;
        $Room = $Room->pluck('id', 'id')->toArray();
        $RoomCount = $RoomCount->count();
        $occupied = RoomDateView::whereDate('date', $data['date']);
        $occupied = $occupied->whereIn('status', [Rentout::CheckIn]);
        $occupied = $occupied->distinct('room_id');
        $occupied = $occupied->whereIn('room_id', $Room);
        $occupied = $occupied->count();
        $checkout = RentoutRoom::whereDate('check_out_date', date('Y-m-d', strtotime('-1 day', strtotime(request('date')))));
        $checkout = $checkout->whereIn('status', [Rentout::CheckIn]);
        $checkout = $checkout->distinct('room_id');
        $checkout = $checkout->whereIn('room_id', $Room);
        $checkout = $checkout->count();
        $floors = Room::buildingId($data['building_id'])->pluck('floor', 'floor')->toArray();
        foreach ($floors as $floor) {
            $Room = new Room;
            $Room = $Room->buildingId($data['building_id']);
            $Room = $Room->floor($floor);
            $Room = $Room->select('room_no', 'id', 'no_of_beds');
            $Room = $Room->orderBy('room_no');
            $Room = $Room->get()->map(function ($value) {
                $status = RoomDateView::whereDate('date', request('date'));
                $status = $status->whereIn('status', ['Check In', 'Booked']);
                $status = $status->where('room_id', $value['id']);
                $status = $status->value('status') ?? '';
                $value['status'] = $status;

                return $value;
            });
            $single['floor'] = $floor;
            $single['total_no_of_beds'] = $Room->sum('no_of_beds');
            $single['available_no_of_beds'] = $Room->sum('no_of_beds');
            $Room = $Room->toArray();
            foreach ($Room as $i => $value) {
                if ($value['status']) {
                    switch ($value['status']) {
                        case Rentout::Booked:
                        $single[$i] = "<span class='badge bg-label-primary booked-box'><u>".$value['room_no'].'</u><br> <br><span style="color:red">'.$value['no_of_beds'].'</span></span>';
                        $single['available_no_of_beds'] -= $value['no_of_beds'];
                        break;
                        case Rentout::CheckIn:
                        $single[$i] = "<span class='badge bg-label-info check-in-box'><u>".$value['room_no'].'</u><br> <br><span style="color:red">'.$value['no_of_beds'].'</span></span>';
                        $single['available_no_of_beds'] -= $value['no_of_beds'];
                        break;
                    }
                } else {
                    $RentoutRoom = RentoutRoom::whereDate('check_out_date', date('Y-m-d', strtotime('-1 day', strtotime(request('date')))));
                    $RentoutRoom = $RentoutRoom->whereIn('status', ['Check In']);
                    $RentoutRoom = $RentoutRoom->where('room_id', $value['id']);
                    $RentoutRoom = $RentoutRoom->count();
                    if($RentoutRoom) {
                        $single[$i] = "<span class='badge bg-label-secondary check-out-box'><u>".$value['room_no'].'</u><br> <br><span style="color:red">'.$value['no_of_beds'].'</span></span>';
                    } else {
                        $single[$i] = '<u>'.$value['room_no'].'</u><br>  <span style="color:red">'.$value['no_of_beds'].'</span>';
                    }
                }
            }
            $list[] = $single;
        }
        $total_no_of_beds = array_sum(array_column($list, 'total_no_of_beds'));
        $available_beds = array_sum(array_column($list, 'available_no_of_beds'));
        $response = [
            'draw' => intval($data['draw']),
            'recordsTotal' => intval(count($floors)),
            'recordsFiltered' => intval(count($floors)),
            'data' => $list,
            'vacant' => $RoomCount - $occupied,
            'occupied' => $occupied,
            'checkout' => $checkout,
            'total_no_of_beds' => $total_no_of_beds,
            'available_beds' => $available_beds,
        ];

        return $response;
    }

    public function RoomPlanDataTable(Request $request)
    {
        $data = $this->RoomPlanData($request->all());
        echo json_encode($data);
        exit;
    }

    public function RoomPlanPrint($date)
    {
        $room_count = Room::buildingId(session('building_id'))->select(DB::raw('count(floor) as room_count'))->groupBy('floor')->orderByRaw('count(floor) DESC')->value('room_count');
        $data['date'] = $date;
        $data['building_id'] = session('building_id');
        $data['draw'] = 1;
        $data = $this->RoomPlanData($data);

        return view('admin.building.room.plan_pdf', compact('room_count', 'data'));
    }

    public function RoomStatusPrint(Request $request)
    {
        dd($request->all());
        $room_count = Room::buildingId(session('building_id'))->select(DB::raw('count(floor) as room_count'))->groupBy('floor')->orderByRaw('count(floor) DESC')->value('room_count');
        $data['date'] = $date;
        $data['building_id'] = session('building_id');
        $data['draw'] = 1;
        $data = $this->RoomPlanData($data);

        return view('admin.building.room.plan_pdf', compact('room_count', 'data'));
    }
}
