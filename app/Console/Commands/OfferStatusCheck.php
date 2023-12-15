<?php

namespace App\Console\Commands;

use App\Models\Offer;
use Illuminate\Console\Command;

class OfferStatusCheck extends Command
{
    protected $signature = 'offer:status_check';

    protected $description = 'To Check the offer status check';

    public function handle()
    {
        $Offer = Offer::active();
        $Offer = $Offer->where('end_date', '<', date('Y-m-d'));
        $Offer->update(['status' => Offer::Disabled]);

        $Offer = Offer::disabled();
        $Offer = $Offer->where('start_date', '>=', date('Y-m-d'));
        $Offer->update(['status' => Offer::Active]);

        return Command::SUCCESS;
    }
}
