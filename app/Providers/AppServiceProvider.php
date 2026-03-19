<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Load fungsi helper global (rupiah, dll.)
        $helpersPath = app_path('helpers.php');
        if (file_exists($helpersPath)) {
            require_once $helpersPath;
        }
    }

    public function boot(): void
    {
        Carbon::setLocale('id');
        Paginator::defaultView('vendor.pagination.custom');
        Model::preventSilentlyDiscardingAttributes(! app()->isProduction());
    }
}
