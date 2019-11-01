<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('price', 100);
            $table->string('class', 100);
            $table->string('date', 100);
            $table->string('distance',100)->nullable();
            $table->string('time',100)->nullable();
            $table->string('source',200)->nullable();
            $table->string('destination',200)->nullable();
            $table->string('qr_code',200)->nullable();
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
        Schema::dropIfExists('ticket_details');
    }
}
