<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User; // <-- Tambahan
use Illuminate\Support\Facades\Gate; // <-- Tambahan

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bikin Gate/Satpam bernama 'manage-product'
        Gate::define('manage-product', function (User $user) {
            // Hanya izinkan jika usertype-nya adalah 'admin'
            return $user->usertype === 'admin';
        });
    }
}