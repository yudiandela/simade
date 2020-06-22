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
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('status', ['New', 'On Progress', 'Done', 'Cancel', 'Pending', 'Complete', 'Reject'])->nullable();
            $table->enum('handler', ['Verificator', 'Deployment', 'Manager CS'])->nullable();
            $table->date('estimated_time')->nullable();
            $table->enum('verificator_1', ['Pending', 'Complete', 'Reject'])->nullable();
            $table->enum('verificator_2', ['Pending', 'Complete', 'Reject'])->nullable();
            $table->enum('manager_1', ['Pending', 'Complete', 'Reject'])->nullable();
            $table->enum('manager_2', ['Pending', 'Complete', 'Reject'])->nullable();
            $table->enum('deployment_1', ['Pending', 'Complete', 'Reject'])->nullable();
            $table->enum('deployment_2', ['Pending', 'Complete', 'Reject'])->nullable();
            $table->date('verificator_1_date')->nullable();
            $table->date('verificator_2_date')->nullable();
            $table->date('manager_1_date')->nullable();
            $table->date('manager_2_date')->nullable();
            $table->date('deployment_1_date')->nullable();
            $table->date('deployment_2_date')->nullable();
            $table->date('work_date')->nullable();
            $table->string('note')->default('-')->nullable();
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
