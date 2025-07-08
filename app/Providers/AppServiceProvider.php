<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Service;
use App\Models\SparePart;

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
    public function boot()
    {
        // Kirim data ke semua view yang menggunakan price-list component
        View::composer('components.price-list', function ($view) {
            $cheapestService = Service::min('biaya_service') ?? 25000;
            $cheapestSparePart = SparePart::min('harga_barang') ?? 25000;

            // Cara yang benar untuk passing multiple data
            $view->with([
                'cheapestService' => $cheapestService,
                'cheapestSparePart' => $cheapestSparePart
            ]);
        });
    }
}
