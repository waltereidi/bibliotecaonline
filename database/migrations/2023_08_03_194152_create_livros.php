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
        Schema::create('livros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('titulo' , 60);
            $table->string('isbn' , 20 )->nullable();
            $table->string('descricao' ,1024 )->nullable();
            $table->smallInteger('visibilidade')->default(0)
                ->comment('0 privado | 1 publico | 2 amigos');
            $table->string('capalivro',512)->nullable();
            $table->string('genero' , 30 )->nullable();
            $table->string('idioma' , 30 )->nullable();

            $table->unsignedBigInteger('users_id');
            $table->foreign('users_id')
                ->references('id')->on('users');
            
            $table->unsignedBigInteger('autores_id');
            $table->foreign('autores_id')
                ->references('id')->on('autores');
            
            $table->unsignedBigInteger('editoras_id');
            $table->foreign('editoras_id')
                ->references('id')->on('editoras');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livros');
    }
};
