<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odbs', function (Blueprint $table) {
            $table->id();
            $table->string('datel');
            $table->decimal('locn_x', 11, 7);
            $table->decimal('locn_y', 11, 7);
            $table->string('nama_odp');
            $table->bigInteger('real_isiska_avai');
            $table->bigInteger('real_isiska_total');
            $table->bigInteger('real_occupancy');
            $table->string('status');
            $table->string('sto');
            $table->string('witel');
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
        Schema::dropIfExists('odbs');
    }
}
