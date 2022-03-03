<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(App\Models\User::class, "user_id");
            $table->string('title', 1000);
            $table->string('slug', 1000);
            $table->tinyInteger('status');
            $table->string('image', 255)->nullable();
            $table->longText('description')->nullable();
            $table->foreignIdFor(App\Models\Client::class, 'client_id');
            $table->foreignIdFor(App\Models\Employe::class, 'employe_id');
            $table->timestamps();
            $table->timestamp('expire_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}
