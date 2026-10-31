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
        Schema::table('releves', function (Blueprint $table) {
            //
            $table->dropForeign(['etudiant_id']);
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('releves', function (Blueprint $table) {
            //
                  $table->dropForeign(['etudiant_id']);
            $table->foreign('etudiant_id')->references('id')->on('etudiants');
        });
    }
};
