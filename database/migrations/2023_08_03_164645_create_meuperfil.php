<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
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
            $table->date('datanascimento')->nullable(); 

            $table->integer('users_id')->unsigned()->uniqid();
            $table->foreign('users_id')
                ->references('id')->on('users');

        });
        $user = User::where('email' , '=' , 'testCase@email.com')->first(); 
        DB::table('meuperfil')->insert(array([
            'users_id' => $user->id 
        ]));

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meuperfil');
    }
};
