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
        Schema::table('signature_cachets', function (Blueprint $table) {
            //
            $table->string('fonction')->after('id');
             $table->unique(['fonction', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signature_cachets', function (Blueprint $table) {
            //
            $table->dropUnique(['fonction', 'type']);
            $table->dropColumn('fonction');
        });
    }
};
