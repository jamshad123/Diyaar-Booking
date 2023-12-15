<?php

namespace App\Console\Commands;

use App\Models\Rentout;
use Illuminate\Console\Command;

class CancelPastBookings extends Command
{
    protected $signature = 'cancel:past_booked_rooms';

    protected $description = 'To Cancel a Past Date booked Rooms';

    public function handle()
    {
        $lists = Rentout::where('check_out_date', '<=', date('Y-m-d'));
        $lists = $lists->where('status', Rentout::Booked);
        $lists = $lists->get();
        foreach($lists as $list) {
            $list->status = Rentout::Cancelled;
            $list->save();
            $list->rentoutRooms()->update(['status' => Rentout::Cancelled]);
        }

        return Command::SUCCESS;
    }
}
