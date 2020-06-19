<?php

use App\Survey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterSurveysTableChangeStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->renameColumn('status', 'tmpStatus');
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->enum('status', ['New', 'On Progress', 'Done', 'Cancel'])->after('tmpStatus');
        });

        $all = Survey::get();
        foreach ($all as $item) {
            Survey::where('id', $item['id'])->update(['status' => $item['tmpStatus']]);
        }

        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('tmpStatus');
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
            $table->renameColumn('status', 'tmpStatus');
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->enum('status', ['On Progress', 'Done', 'Cancel'])->after('tmpStatus');
        });

        $all = Survey::get();
        foreach ($all as $item) {
            if ($item['tmpStatus'] == 'New') {
                $item['tmpStatus'] = 'On Progress';
            }
            Survey::where('id', $item['id'])->update(['status' => $item['tmpStatus']]);
        }

        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('tmpStatus');
        });
    }
}
