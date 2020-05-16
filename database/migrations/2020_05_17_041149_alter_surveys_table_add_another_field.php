<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSurveysTableAddAnotherField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->string('regional')->nullable();
            $table->string('witel')->nullable();
            $table->string('mode')->nullable();
            $table->string('status')->nullable();
            $table->string('task_owner')->nullable();
            $table->string('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('regional');
            $table->dropColumn('witel');
            $table->dropColumn('mode');
            $table->dropColumn('status');
            $table->dropColumn('task_owner');
            $table->dropColumn('date');
        });
    }
}
