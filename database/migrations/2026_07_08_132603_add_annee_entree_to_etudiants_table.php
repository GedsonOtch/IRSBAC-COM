<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->foreignId('annee_entree_id')
                ->nullable()
                ->after('filiere_id')
                ->constrained('annees_academiques')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropForeign(['annee_entree_id']);
            $table->dropColumn('annee_entree_id');
        });
    }
};