<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:room_status')->daily()->at('20:00')->emailOutputTo('raheescv1992@gmail.com');
        $schedule->command('cancel:past_booked_rooms')->daily()->at('20:00')->emailOutputTo('raheescv1992@gmail.com');
        $schedule->command('offer:status_check')->daily()->at('20:00')->emailOutputTo('raheescv1992@gmail.com');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
