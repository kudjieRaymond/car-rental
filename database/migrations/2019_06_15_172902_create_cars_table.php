<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
					$table->uuid('id');
					$table->primary('id');
					$table->string('name');
					$table->string('reg_num')->nullable();
					$table->string('description')->nullable();
					$table->string('color')->nullable();
					$table->boolean('available')->default(0);
					$table->uuid('car_type_id');
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
        Schema::dropIfExists('cars');
    }
}
