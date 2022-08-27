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
        Schema::create('bank_nifty_nse_data', function (Blueprint $table) {
            $table->id();
            $table->string('bank_nifty_expiry');
            $table->json('filtered_bank_nifty_nse_data')->nullable();
            $table->json('all_bank_nifty_nse_data')->nullable();
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
        Schema::dropIfExists('bank_nifty_nse_data');
    }
};
