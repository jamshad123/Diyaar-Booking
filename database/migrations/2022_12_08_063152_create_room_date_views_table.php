<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private function createView(): string
    {
        return <<<'SQL'
        CREATE VIEW room_date_views AS
        WITH RECURSIVE dates AS (
            SELECT
                id,
                rentout_id,
                building_id,
                room_id,
                check_out_date,
                check_in_date AS date,
                amount,
                total,
                status
            FROM rentout_rooms
            UNION ALL
            SELECT
                id,
                rentout_id,
                building_id,
                room_id,
                check_out_date,
                date + INTERVAL 1 DAY,
                amount,
                total,
                status
            FROM dates
            WHERE date < check_out_date
        )
        SELECT * FROM dates;
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
        DROP VIEW IF EXISTS `room_date_views`;
        SQL;
    }

    public function down()
    {
        DB::statement($this->dropView());
    }
};
