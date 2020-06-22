<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->string('survey_id')->nullable();
            $table->string('name');
            $table->string('address');
            $table->string('province');
            $table->string('districts');
            $table->string('sub_district');
            $table->string('ktp');
            $table->string('phone');
            $table->integer('price_from')->nullable();
            $table->integer('price_to')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->enum('status', ['New', 'On Progress', 'Done', 'Cancel']);
            $table->enum('handler', ['Verificator', 'Deployment', 'Manager CS']);
            $table->date('estimated_time')->nullable();
            $table->enum('validate_1', ['Pending', 'Complete', 'Reject']);
            $table->enum('validate_2', ['Pending', 'Complete', 'Reject']);
            $table->enum('validate_3', ['Pending', 'Complete', 'Reject']);
            $table->enum('validate_4', ['Pending', 'Complete', 'Reject']);
            $table->enum('validate_5', ['Pending', 'Complete', 'Reject']);
            $table->enum('validate_6', ['Pending', 'Complete', 'Reject']);
            $table->string('note')->default('-');
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
        Schema::dropIfExists('surveys');
    }
}
