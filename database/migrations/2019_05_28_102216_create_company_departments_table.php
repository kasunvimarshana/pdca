<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->boolean('is_visible')->default(1)->nullable();
            $table->string('company_pk')->index()->nullable();
            $table->string('department_pk')->index()->nullable();
            $table->string('colour')->index()->nullable();
            //$table->softDeletes();
            
            $table->foreign('company_pk')->references('name')->on('companies')->onUpdate('cascade');
            $table->foreign('department_pk')->references('name')->on('departments')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_departments');
    }
}
