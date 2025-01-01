<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('professeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('numero_telephone', 15)->nullable();
            // Ajout des clés étrangères
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('professeurs');
    }
};