<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trains', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('train_id', 100)->nullable();
            $table->string('train_no',100)->nullable();
            $table->string('arrival_time',100)->nullable();
            $table->string('departur_time',100)->nullable();
            $table->string('source',100);
            $table->string('destination',100);
            $table->string('train_name',200)->nullable();
            $table->string('train_type',100)->nullable();
            $table->string('train_frequency',50)->nullable();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trains');
    }
}
