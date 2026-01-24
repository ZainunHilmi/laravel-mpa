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
        Schema::table('products', function (Blueprint $table) {
            // Add category_id foreign key
            // Assuming categories table exists. If strictly following the prompt without assuming categories table, allow nullable or just integer.
            // But I created categories table.
            $table->foreignId('category_id')->nullable()->after('stock')->constrained('categories')->nullOnDelete();

            // Drop old category enum
            $table->dropColumn('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->enum('category', ['food', 'drink', 'snack'])->nullable(); // Restore logic
        });
    }
};
