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
    Schema::create('inventory_movements', function (Blueprint $table) {
        $table->id();

        $table->foreignId('product_id')
            ->constrained()
            ->restrictOnDelete();

        $table->foreignId('user_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        $table->string('type', 30);
        $table->decimal('quantity', 12, 2);

        $table->decimal('stock_before', 12, 2);
        $table->decimal('stock_after', 12, 2);

        $table->decimal('unit_cost', 12, 2)->nullable();

        $table->string('reference')->nullable();
        $table->text('reason')->nullable();

        $table->timestamps();

        $table->index(['product_id', 'created_at']);
        $table->index('type');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
