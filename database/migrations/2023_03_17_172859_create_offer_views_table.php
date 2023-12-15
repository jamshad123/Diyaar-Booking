<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function createView(): string
    {
        return <<<'SQL'
        CREATE VIEW offer_views AS
        with recursive ranges as (
            SELECT
            building_id,
            amount,
            start_date as date,
            status
            FROM offers where start_date <> end_date
            UNION ALL
            SELECT
            ranges.building_id,
            ranges.amount,
            ranges.date + interval 1 day,
            ranges.status
            FROM ranges
            JOIN offers on date < end_date
        )
        SELECT * From ranges
        UNION
        SELECT
        building_id,
        amount,
        start_date as date,
        status
        FROM offers where start_date = end_date
        ;
        SQL;
    }

    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    private function dropView(): string
    {
        return <<<'SQL'
        DROP VIEW IF EXISTS `offer_views`;
        SQL;
    }

    public function down()
    {
        DB::statement($this->dropView());
    }
};
