<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckCouponExpiry extends Command
{
    protected $signature = 'check:coupon_expiry';

    protected $description = 'To Delete all the Expired coupons';

    public function handle()
    {
        return Command::SUCCESS;
    }
}
