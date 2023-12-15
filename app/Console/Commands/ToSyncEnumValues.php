<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ToSyncEnumValues extends Command
{
    protected $signature = 'sync:latest_enum';

    protected $description = 'To Change Enum values Based on Helper Functions';

    public function handle()
    {
        DB::statement("DELETE FROM migrations WHERE `migrations`.`migration` = '2023_03_18_053728_add_new_status_name_to_rentouts_table'");

        return Command::SUCCESS;
    }
}
