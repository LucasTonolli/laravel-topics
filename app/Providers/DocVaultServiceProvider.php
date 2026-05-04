<?php

namespace App\Providers;

use App\Contracts\DocumentServiceInterface;
use App\Services\DocumentService;
use Illuminate\Support\ServiceProvider;

class DocVaultServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(DocumentServiceInterface::class, DocumentService::class);

        $this->app->when(DocumentService::class)
            ->needs('$disk') // Nome exato do parâmetro no construtor
            ->giveConfig('docvault.upload_disk');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
