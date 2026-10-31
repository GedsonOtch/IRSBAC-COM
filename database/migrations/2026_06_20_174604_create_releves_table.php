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
       Schema::create('releves', function (Blueprint $table) {

    $table->id();

    $table->foreignId('etudiant_id')
          ->constrained('etudiants');

    $table->foreignId('annee_academique_id')
          ->constrained('annees_academiques');

    $table->integer('semestre');

    $table->string('numero');

    $table->string('pdf_path');

    $table->decimal('moyenne',5,2);

    $table->integer('credits_valides');

    $table->string('decision');


    $table->timestamps();
});;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('releves');
    }
};
