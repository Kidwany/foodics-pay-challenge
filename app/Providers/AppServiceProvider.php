<?php

namespace App\Providers;

use App\Interfaces\Transaction\TransactionServiceInterface;
use App\Repositories\Client\ClientRepository;
use App\Repositories\Client\ClientRepositoryEloquent;
use App\Repositories\PaymentProvider\PaymentProviderRepository;
use App\Repositories\PaymentProvider\PaymentProviderRepositoryEloquent;
use App\Repositories\Transaction\ArchivedTransactionRepository;
use App\Repositories\Transaction\ArchivedTransactionRepositoryEloquent;
use App\Repositories\Transaction\TransactionRepository;
use App\Repositories\Transaction\TransactionRepositoryEloquent;
use App\Services\Transaction\TransactionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Repository
        $this->app->bind(TransactionRepository::class, TransactionRepositoryEloquent::class);
        $this->app->bind(ArchivedTransactionRepository::class, ArchivedTransactionRepositoryEloquent::class);
        $this->app->bind(ClientRepository::class, ClientRepositoryEloquent::class);
        $this->app->bind(PaymentProviderRepository::class, PaymentProviderRepositoryEloquent::class);


        // Register Services
        $this->app->bind(TransactionServiceInterface::class, TransactionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
