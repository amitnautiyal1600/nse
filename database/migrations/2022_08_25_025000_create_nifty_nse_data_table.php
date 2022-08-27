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
        Schema::create('nifty_nse_data', function (Blueprint $table) {
            $table->id();
            $table->string('nifty_expiry');
            $table->json('filtered_nifty_nse_data')->nullable();
            $table->json('all_nifty_nse_data')->nullable();
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
        Schema::dropIfExists('nifty_nse_data');
    }
};
