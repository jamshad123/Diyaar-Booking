<?php

namespace App\Console\Commands\Reservation;

use App\Models\Rentout;
use App\Models\Room;
use App\Models\Views\RoomDateView;
use Illuminate\Console\Command;

class RoomStatus extends Command
{
    protected $signature = 'update:room_status';

    protected $description = 'Update the room status based on room_date_views dates';

    public function handle()
    {
        $date = date('Y-m-d');
        $Rooms = RoomDateView::where('date', $date)->get();
        foreach ($Rooms as $key => $value) {
            $Room = Room::find($value->room_id);
            if($Room) {
                switch ($value->status) {
                    case Rentout::Booked:
                    $Room->status = Room::Booked;
                    break;
                    case Rentout::CheckIn:
                    $Room->status = Room::Occupied;
                    break;
                    case Rentout::CheckOut:
                    $Room->status = Room::Vacant;
                    break;
                    case Rentout::Cancelled:
                    $Room->status = Room::Vacant;
                    break;
                }
                $Room->save();
            }
        }

        return Command::SUCCESS;
    }
}
