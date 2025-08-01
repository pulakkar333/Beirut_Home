<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update any NULL values to false for boolean columns
        DB::table('re_properties')
            ->whereNull('never_expired')
            ->update(['never_expired' => false]);
            
        DB::table('re_properties')
            ->whereNull('auto_renew')
            ->update(['auto_renew' => false]);
            
        DB::table('re_properties')
            ->whereNull('is_featured')
            ->update(['is_featured' => false]);
    }

    public function down(): void
    {
        // No need to revert this change
    }
};