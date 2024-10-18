<?php

namespace App\Providers;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

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
//        DB::listen(function ($query) {
//            Log::info('Query Executed: ' . $query->sql);
//            Log::info('Bindings: ' . implode(', ', $query->bindings));
//            Log::info('Time: ' . $query->time . ' ms');
//        });
    }
}
