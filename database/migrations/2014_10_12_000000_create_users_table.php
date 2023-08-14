<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(0);
            $table->string('api_token', 64 )->nullable();
            $table->date('validade_token')->nullable();
        });
        DB::table('users')->insert(array(['name' => 'TestCase' ,'email' =>'testCase@email.com' , 'password' => 'testCase']));
        DB::table('users')->insert(array(['name' => 'TestCaseAmigo' ,'email' =>'testCaseAmigo@email.com' , 'password' => 'testCase']));
    }
        
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
