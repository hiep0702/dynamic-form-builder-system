<?php

namespace App\Providers;

use App\Domain\Field\FieldHandlerRegistry;
use App\Domain\Field\Handlers\NumberFieldHandler;
use App\Domain\Field\Handlers\TextFieldHandler;
use App\Domain\Repositories\FormRepositoryInterface;
use App\Domain\Repositories\SubmissionRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\EloquentFormRepository;
use App\Infrastructure\Persistence\Repositories\EloquentSubmissionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FormRepositoryInterface::class, EloquentFormRepository::class);
        $this->app->bind(SubmissionRepositoryInterface::class, EloquentSubmissionRepository::class);

        $this->app->singleton(FieldHandlerRegistry::class, function () {
            return new FieldHandlerRegistry([
                new TextFieldHandler(),
                new NumberFieldHandler(),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
