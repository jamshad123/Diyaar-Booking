<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Rentout;
use Livewire\Component;

class BookingList extends Component
{
    public function mount($date)
    {
        $this->Rentout = Rentout::whereBetween('check_in_date', [date('Y-m-d 0:0:0', strtotime($date)), date('Y-m-d 23:59:59', strtotime($date))])->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard.booking-list');
    }
}
