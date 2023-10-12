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
        Schema::table('mensagens' , function( Blueprint $table ){
            $table->dropForeign(['livros_id']);
            $table->foreign('livros_id')
            ->references('id')->on('livros')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts' , function(Blueprint $table ){

        });
    }
};
