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
            $table->timestamps();
            $table->string('profile_picture' , 1024 )->nullable(); 
            $table->string('introducao' , 1024 )->nullable();

            $table->integer('users_id')->unsigned();
            $table->foreign('users_id')
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
