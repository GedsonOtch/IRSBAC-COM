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
        Schema::table('admins', function (Blueprint $table) {

            $table->string('role')
                  ->default('admin')
                  ->after('email');

                     $table->boolean('is_active')
              ->default(true);

        $table->timestamp('last_login_at')
              ->nullable();


        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {

             if (Schema::hasColumn('admins', 'role')) {
            $table->dropColumn('role');
        }

        if (Schema::hasColumn('admins', 'is_active')) {
            $table->dropColumn('is_active');
        }

        if (Schema::hasColumn('admins', 'last_login_at')) {
            $table->dropColumn('last_login_at');
        }
        });
    }
   
    
};
