<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the table exists before adding columns
        if (Schema::hasTable('tbl_order')) {
            Schema::table('tbl_order', function (Blueprint $table) {
                // Add Stripe fields if they don't already exist
                if (!Schema::hasColumn('tbl_order', 'stripe_session_id')) {
                    $table->string('stripe_session_id')->nullable()->unique();
                }
                if (!Schema::hasColumn('tbl_order', 'stripe_customer_id')) {
                    $table->string('stripe_customer_id')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('tbl_order')) {
            Schema::table('tbl_order', function (Blueprint $table) {
                if (Schema::hasColumn('tbl_order', 'stripe_session_id')) {
                    $table->dropColumn('stripe_session_id');
                }
                if (Schema::hasColumn('tbl_order', 'stripe_customer_id')) {
                    $table->dropColumn('stripe_customer_id');
                }
            });
        }
    }
};
