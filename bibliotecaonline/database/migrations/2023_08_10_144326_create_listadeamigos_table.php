<?php

use App\Models\MeuPerfil;
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
        Schema::create('listadeamigos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('meuperfil_id');
            $table->foreign('meuperfil_id')
                ->references('id')->on('meuperfil')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('meuperfilamigo_id');
            $table->foreign('meuperfilamigo_id')
                ->references('id')->on('meuperfil')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listadeamigos');
    }
};
