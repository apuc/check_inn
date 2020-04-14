<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckedInnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checked_inns', function (Blueprint $table) {
            $table->id();
            $table->string('inn');
            $table->boolean('status')->nullable();
            $table->string('message');
            $table->string('code')->nullable();
            $table->smallInteger('response_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checked_inns');
    }
}
