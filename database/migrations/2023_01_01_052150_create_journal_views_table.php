<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private function createView(): string
    {
        return <<<'SQL'
        CREATE VIEW `journal_views` AS
        SELECT
        R.id AS model_id,
        'Rentout' AS model,
        R.payment_mode,
        R.advance_amount AS amount,
        'Advance Amount' AS reason,
        R.created_by,
        R.updated_by,
        R.created_at,
        R.updated_at
        FROM rentouts AS R
        where R.deleted_at is NULL
        UNION
        SELECT
        R.id AS model_id,
        'Rentout' AS model,
        R.security_deposit_payment_mode AS payment_mode,
        R.security_amount AS amount,
        'Security Deposit' AS reason,
        R.created_by,
        R.updated_by,
        R.created_at,
        R.updated_at
        FROM rentouts AS R
        where R.deleted_at is NULL
        UNION
        SELECT
        CP.checkout_id AS model_id,
        'CheckoutPayment' AS model,
        CP.payment_mode,
        CP.amount,
        'Payment Amount' AS reason,
        CP.created_by,
        CP.updated_by,
        CP.created_at,
        CP.updated_at
        FROM checkout_payments AS CP
        UNION
        SELECT
        C.id AS model_id,
        'CheckoutPayment' AS model,
        C.security_deposit_payment_mode AS payment_mode,
        C.security_amount*-1 AS amount,
        'Security Deposit Return Amount' AS reason,
        C.created_by,
        C.updated_by,
        C.created_at,
        C.updated_at
        FROM checkouts AS C
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
        DROP VIEW IF EXISTS `journal_views`;
        SQL;
    }

    public function down()
    {
        DB::statement($this->dropView());
    }
};
