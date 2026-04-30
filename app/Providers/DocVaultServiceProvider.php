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
        $this->app->singleton(
            DocumentServiceInterface::class,
            function ($app) {
                return new DocumentService(
                    maxSize: config('docvault.max_upload_size'),
                    allowedMimeTypes: config('docvault.allowed_file_types'),
                    disk: config('docvault.upload_disk'),
                );
            }
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
