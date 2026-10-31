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
    Schema::table('ues', function (Blueprint $table) {
        $table->dropForeign(['filiere_id']);
        $table->dropColumn('filiere_id');
    });
}

public function down(): void
{
    Schema::table('ues', function (Blueprint $table) {
        $table->foreignId('filiere_id')->constrained()->cascadeOnDelete();
    });
} 

};
