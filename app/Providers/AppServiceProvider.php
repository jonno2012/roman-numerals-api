<?php

namespace App\Providers;

use App\Repositories\EloquentNumeralsRepository;
use App\Repositories\NumeralsRepositoryInterface;
use App\Services\IntegerConverterInterface;
use App\Services\RomanNumeralConverter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IntegerConverterInterface::class, RomanNumeralConverter::class);
        $this->app->bind(NumeralsRepositoryInterface::class, EloquentNumeralsRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
