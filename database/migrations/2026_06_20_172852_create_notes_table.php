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
       Schema::create('notes', function (Blueprint $table) {

    $table->id();

    $table->foreignId('etudiant_id')
        ->constrained('etudiants')
        ->cascadeOnDelete();

    $table->foreignId('ecue_id')
        ->constrained('ecues')
        ->cascadeOnDelete();

    $table->foreignId('annee_academique_id')
        ->constrained('annees_academiques')
        ->cascadeOnDelete();

    $table->decimal(
        'note',
        5,
        2
    );

    $table->timestamps();

    $table->unique([
        'etudiant_id',
        'ecue_id',
        'annee_academique_id'
    ]);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
