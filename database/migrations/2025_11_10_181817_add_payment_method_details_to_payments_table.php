<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Add missing payment method detail columns
            $table->string('card_last_four', 4)->nullable()->after('payment_method');
            $table->string('card_type', 20)->nullable()->after('card_last_four');
            $table->string('bank_name')->nullable()->after('card_type');
            $table->string('wallet_type', 50)->nullable()->after('bank_name');
            $table->string('wallet_transaction_id')->nullable()->after('wallet_type');
            $table->string('check_number')->nullable()->after('wallet_transaction_id');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn([
                'card_last_four',
                'card_type',
                'bank_name',
                'wallet_type',
                'wallet_transaction_id',
                'check_number'
            ]);
        });
    }
};
