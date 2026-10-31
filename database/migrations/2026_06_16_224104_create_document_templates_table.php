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
        Schema::create('document_templates', function (Blueprint $table) {
            $table->id();
   $table->string('nom');

    $table->string('pdf_path');

    // Directeur des études

    $table->float('signature_de_x')->nullable();
    $table->float('signature_de_y')->nullable();

    $table->float('cachet_de_x')->nullable();
    $table->float('cachet_de_y')->nullable();

    // Directeur

    $table->float('signature_directeur_x')->nullable();
    $table->float('signature_directeur_y')->nullable();

    $table->float('cachet_directeur_x')->nullable();
    $table->float('cachet_directeur_y')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_templates');
    }
};
