<?php

use Illuminate\Support\Facades\Route;

Route::post("payment/foodics/webhook", [\App\Modules\PaymentProviders\FoodicsProvider\Controllers\WebhookController::class, 'handle'])->middleware('api');
Route::post("payment/acme/webhook", [\App\Modules\PaymentProviders\AcmeProvider\Controllers\WebhookController::class, 'handle'])->middleware('api');
