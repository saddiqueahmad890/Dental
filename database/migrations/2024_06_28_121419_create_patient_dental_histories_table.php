<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientDentalHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('patient_dental_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->integer('dd_medical_history_id');
            $table->integer('doctor_id');
            $table->text('comments')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patient_dental_histories');
    }
}
