<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class, 'user_id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('profile_picture')->nullable();
            $table->string('address');
            $table->string('phone_number');
            $table->string('start_date'); //job start date
            $table->string('end_date')->nullable(); //job start date
            $table->string('status')->default('active');
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
        Schema::dropIfExists('employes');
    }
}
