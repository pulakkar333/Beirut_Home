<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminCalendarDatesTable extends Migration
{
    public function up()
    {
        Schema::create('admin_calendar_dates', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_calendar_dates');
    }
}
