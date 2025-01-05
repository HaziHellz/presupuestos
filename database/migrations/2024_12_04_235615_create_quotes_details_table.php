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
        Schema::create('quotes_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('registered_price');
            $table->foreignId('quote_id')->constrained('quotes');
            $table->foreignId('concept_id')->constrained('concepts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes_details');
    }
};
