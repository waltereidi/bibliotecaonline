<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aplicativo', function (Blueprint $table) {
            $table->id();
            $table->timestamps(0);
            $table->string('token_aplicacao',64);
            $table->string('nome' , 40);

        });
        DB::table('aplicativo')->insert(array(['token_aplicacao'=> 'f53UhOaoMnMJUUqkWd4QO3aNy4aDaWGhWBYEWeoJPg7OyChLDIpaIb0ZTPkmF2zO' ,
        'nome'=>'bibliotecaOnline']));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aplicativo');
    }
};
