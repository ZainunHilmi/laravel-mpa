<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rename roles to role if it exists, otherwise just add role
            if (Schema::hasColumn('users', 'roles')) {
                $table->renameColumn('roles', 'role');
            } else {
                $table->string('role')->default('user')->after('email');
            }
        });

        // Ensure default logic if needed (it's handled by enum definition usually, but rename keeps it)
        // If it was string/enum before.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->renameColumn('role', 'roles');
            }
        });
    }
};
