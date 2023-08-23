<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_salaries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('basic_salary')->nullable();
            $table->string('incentive_pay')->nullable();
            $table->string('conveyance_allowance')->nullable();
            $table->string('house_rent_allowance')->nullable();
            $table->string('medical_allowance')->nullable();
            $table->string('provident_fund')->nullable();
            $table->string('leaves')->nullable();
            $table->string('prof_tax')->nullable();
            $table->string('health_insurance')->nullable();
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
        Schema::dropIfExists('staff_salaries');
    }
}
