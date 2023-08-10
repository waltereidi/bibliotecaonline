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
        Schema::create('mensagens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('mensagem' ,1024);
            
            $table->integer('meuperfil_id')->unsigned();
            $table->foreign('meuperfil_id')
                ->references('id')->on('users');

            $table->integer('livros_id')->unsigned();
            $table->foreign('livros_id')
                ->references('id')->on('livros');

            $table->boolean('visualizado')->default(false);
            $table->boolean('visivel')->default('true');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensagens');
    }
};
