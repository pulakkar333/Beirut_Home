<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('re_properties', function (Blueprint $table) {
            $table->json('booked_dates')->nullable()->default('[]')->after('never_expired');
        });
    }

    public function down(): void
    {
        Schema::table('re_properties', function (Blueprint $table) {
            $table->dropColumn('booked_dates');
        });
    }
};