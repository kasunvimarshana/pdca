<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePDCASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_d_c_a_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            
            $table->boolean('is_visible')->default(1)->nullable();
            //$table->unsignedBigInteger('created_user')->index()->nullable();
            $table->string('created_user')->index();//->nullable()
            $table->string('company_name');//->nullable()
            $table->string('department_name');//->nullable()
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('p_d_c_a_category_id')->index()->nullable();
            $table->unsignedBigInteger('status_id')->default(null)->nullable();
            $table->dateTime('start_date')->useCurrent()->nullable();
            $table->dateTime('complete_date')->useCurrent()->nullable();
            $table->integer('piority')->default(0)->nullable();
            $table->text('resource_dir')->nullable()->default(null);
            $table->string('colour')->index()->nullable();
            //$table->softDeletes();
            
            $table->foreign('p_d_c_a_category_id')->references('id')->on('p_d_c_a_categories')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_d_c_a_s');
    }
}
