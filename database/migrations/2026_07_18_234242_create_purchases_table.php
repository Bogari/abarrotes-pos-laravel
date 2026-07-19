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
    Schema::create('purchases', function (Blueprint $table) {
        $table->id();

        $table->foreignId('supplier_id')
            ->constrained()
            ->restrictOnDelete();

        $table->foreignId('user_id')
            ->constrained()
            ->restrictOnDelete();

        $table->string('folio')->unique();
        $table->date('purchase_date');

        $table->string('invoice_number')->nullable();
        $table->string('status')->default('completed');

        $table->decimal('subtotal', 12, 2)->default(0);
        $table->decimal('tax', 12, 2)->default(0);
        $table->decimal('total', 12, 2)->default(0);

        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
