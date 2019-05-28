<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePDCAUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_d_c_a_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->boolean('is_visible')->default(1)->nullable();
            $table->unsignedBigInteger('p_d_c_a_id')->index();//->nullable()
            //$table->unsignedBigInteger('own_user')->index()->nullable();
            $table->string('own_user')->index()->nullable();
            $table->string('company_name');//->nullable()
            $table->string('department_name');//->nullable()
            //$table->softDeletes();
            
            $table->foreign('p_d_c_a_id')->references('id')->on('p_d_c_a_s')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_d_c_a_users');
    }
}
