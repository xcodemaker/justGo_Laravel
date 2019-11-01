<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('user_id', 100);
            $table->string('train_id', 100);
            $table->string('ticket_details_id',100);
            $table->index('user_id','user_id_index');
            $table->index('train_id','train_id_index');
            $table->index('ticket_details_id','ticket_details_id_index');
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
        Schema::table('tickets', function ($table) {
            $table->dropIndex('user_id_index');
            $table->dropIndex('train_id_index');
            $table->dropIndex('ticket_details_id_index');
        });
        Schema::dropIfExists('tickets');
    }
}
