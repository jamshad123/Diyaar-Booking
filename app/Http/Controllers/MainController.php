<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use App\Models\Views\RoomDateView;

class MainController extends Controller
{
    public function Dashboard()
    {
        $Buildings = Building::pluck('name', 'id')->toArray();
        $list = [];
        foreach ($Buildings as $id => $name) {
            $list[$name]['Maintenance'] = Room::buildingId($id)->where('status', 'Maintenance')->count();
            $list[$name]['Total'] = Room::buildingId($id)->active()->count();
            $list[$name]['Occupied'] = RoomDateView::where('building_id', $id)->where('date', date('Y-m-d'))->whereIn('status', ['Booked', 'Occupied', 'CheckIn'])->count();
            $list[$name]['Vacant'] = $list[$name]['Total'] - $list[$name]['Occupied'];
        }

        return view('dashboard')
        ->with('list', $list);
    }
}
