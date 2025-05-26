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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_id')->unique();
            $table->char('transaction_code')->unique()->nullable();
            $table->char('track_id')->unique();
            $table->foreignUuid('client_id')->constrained("clients")->onDelete('cascade');
            $table->foreignId('payment_provider_id')->constrained("payment_providers")->onDelete('cascade');
            $table->string('reference')->unique();
            $table->decimal('amount', 15, 2);
            $table->decimal('balance_before', 15, 2);
            $table->decimal('balance_after', 15, 2);
            $table->string('currency')->default('SAR');
            $table->enum('type', ['credit', 'debit'])->index();
            $table->date('transaction_date')->index('idx_transactions_date');
            $table->json('transaction_object')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
