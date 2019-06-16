<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
					$table->uuid('id');
					$table->primary('id');
					$table->uuid('client_id');
					$table->uuid('code');
					$table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
					$table->uuid('car_id');
					$table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
					$table->boolean('returned')->default(0);
					$table->date('start_date')->nullable();
					$table->date('end_date')->nullable();
					$table->uuid('created_by');
					$table->uuid('modified_by')->nullable();
					$table->timestamps();
					$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
}
