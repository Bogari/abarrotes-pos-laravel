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
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();

        $table->string('business_name');
        $table->string('contact_name')->nullable();

        $table->string('tax_id', 20)->nullable()->unique();
        $table->string('phone', 20)->nullable();
        $table->string('email')->nullable();

        $table->string('address')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('postal_code', 10)->nullable();

        $table->text('notes')->nullable();

        $table->boolean('active')->default(true);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
