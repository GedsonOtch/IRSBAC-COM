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
        Schema::create('infoirsbacs', function (Blueprint $table) {
            $table->id();

              $table->string('nom_etablissement');
        $table->string('sigle');
        $table->text('arrete_autorisation')->nullable();

        $table->string('adresse')->nullable();
        $table->string('telephone')->nullable();
        $table->string('email')->nullable();
        $table->string('site_web')->nullable();

        $table->string('directeur')->nullable();
        $table->string('directeur_etudes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infoirsbacs');
    }
};
