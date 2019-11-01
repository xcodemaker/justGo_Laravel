<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('user_id', 100);
            $table->string('first_name',100);
            $table->string('last_name',100);
            $table->string('address',200);
            $table->string('nic_or_passport',50);
            $table->string('contact_number',25)->nullable();
            $table->string('profile_pic',200)->nullable();
            $table->index('user_id','user_id_index');
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
        Schema::table('user_details', function ($table) {
            $table->dropIndex('user_id_index');
        });

        Schema::dropIfExists('user_details');
    }
}
