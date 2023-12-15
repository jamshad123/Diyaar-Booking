<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Customer;
use App\Models\Rentout;
use App\Models\Room;
use App\Models\Views\RoomDateView;
use Livewire\Component;

class Count extends Component
{
    public $today_booking_count;

    public $total_booking_count;

    public $today_check_in_count;

    public $total_amount;

    public $total_customer;

    public $today_available_rooms;

    public $dirty_rooms;

    public function mount()
    {
        $date = date('Y-m-d');
        $total_rooms = Room::where('building_id', session('building_id'))->active()->count();
        $this->today_booking_count = RoomDateView::where('building_id', session('building_id'))->booked()->where('date', $date)->count();
        $this->today_check_in_count = RoomDateView::where('building_id', session('building_id'))->where('date', $date)->checkIn()->count();
        $this->total_amount = Rentout::where('building_id', session('building_id'))->where('flag', Rentout::Approved)->sum('grand_total');
        $this->total_customer = Customer::count();
        $this->today_available_rooms = $total_rooms - $this->today_booking_count - $this->today_check_in_count;
        $this->dirty_rooms = Room::where('building_id', session('building_id'))->hygieneStatus(Room::Dirty)->active()->count();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.count');
    }
}
