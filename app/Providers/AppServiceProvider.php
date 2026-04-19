<?php

namespace App\Providers;

use App\Domain\Field\FieldHandlerRegistry;
use App\Domain\Field\Handlers\CheckboxFieldHandler;
use App\Domain\Field\Handlers\DateFieldHandler;
use App\Domain\Field\Handlers\FileFieldHandler;
use App\Domain\Field\Handlers\NumberFieldHandler;
use App\Domain\Field\Handlers\SelectFieldHandler;
use App\Domain\Field\Handlers\TextareaFieldHandler;
use App\Domain\Field\Handlers\TextFieldHandler;
use App\Domain\Form\Repositories\FormRepositoryInterface;
use App\Domain\Submission\Repositories\SubmissionRepositoryInterface;
use App\Infrastructure\Form\Repositories\EloquentFormRepository;
use App\Infrastructure\Submission\Repositories\EloquentSubmissionRepository;
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
                new CheckboxFieldHandler(),
                new DateFieldHandler(),
                new SelectFieldHandler(),
                new TextareaFieldHandler(),
                new FileFieldHandler(),
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
