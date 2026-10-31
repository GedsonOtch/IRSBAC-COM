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
       Schema::create('document_verifications', function (Blueprint $table) {

    $table->id();

    // Identifiant unique contenu dans le QR Code
    $table->uuid('verification_token')->unique();

    // Type du document
    $table->string('document_type');

    // ID du document généré (relevé, attestation...)
    $table->unsignedBigInteger('document_id');

    // Étudiant concerné
    $table->foreignId('etudiant_id')
          ->constrained()
          ->cascadeOnDelete();

    // Chemin du QR Code généré
    $table->string('qr_code_path')->nullable();

    // Permet d'invalider un document si besoin
    $table->boolean('is_valid')->default(true);

    $table->timestamp('generated_at');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_verifications');
    }
};
