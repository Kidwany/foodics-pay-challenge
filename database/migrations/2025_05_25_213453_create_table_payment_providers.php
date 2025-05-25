<?php

use Database\Seeders\PaymentProvidersSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->integer('priority');
            $table->boolean('supports_incoming')->default(false);
            $table->boolean('supports_outgoing')->default(false);
            $table->boolean('is_active')->default(false);
            $table->json('config')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Artisan::call('db:seed', [
            '--class' => PaymentProvidersSeeder::class,
            '--force' => true,
            '--env' => 'testing',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_providers');
    }
};
