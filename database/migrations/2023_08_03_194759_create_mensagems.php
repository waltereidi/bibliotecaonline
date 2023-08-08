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
        Schema::create('mensagems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('mensagem' ,1024);
            
            $table->integer('origem_user_id')->unsigned();
            $table->foreign('origem_user_id')
                ->references('id')->on('users');

            $table->integer('liros_id')->unsigned();
            $table->foreign('liros_id')
                ->references('id')->on('livros');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensagems');
    }
};
