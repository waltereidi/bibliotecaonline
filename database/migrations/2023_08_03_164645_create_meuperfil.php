<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meuperfil', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps(0);
            $table->string('profile_picture' , 128 )->nullable(); 
            $table->string('introducao' , 1024 )->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meuperfil');
    }
};
