<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarRentalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_rental', function (Blueprint $table) {
					$table->uuid('rental_id');
					$table->uuid('car_id');
			
					$table->boolean('returned')->default(0);
					$table->primary(['car_id', 'rental_id']);
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
        Schema::dropIfExists('car_rental');
    }
}
