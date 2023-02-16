<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        schema::create('wait_numbers', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waiting_no')->nullable(false)->unique();
            $table->string('card_id')->nullable(false)->unique();
            $table->boolean('is_cut_wait')->nullable(false);
            $table->boolean('is_cut_done')->nullable(false);
            $table->boolean('is_cut_call')->nullable(false);
            $table->boolean('is_cut_now')->nullable(false);
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
        Schema::dropIfExists('wait_numbers');
    }
};
