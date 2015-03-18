<?php namespace Phoenix\EloquentMeta;

use Illuminate\Support\ServiceProvider as BaseService;

class ServiceProvider extends BaseService
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Booting
     */
    public function boot()
    {
        $this->app->bind(
            'phoenix.metable',
            'Phoenix\EloquentMeta\CreateMetaTableCommand'
        );

        $this->commands('phoenix.metable');

        $this->publishes([
            __DIR__.'/../../migrations/' => base_path('/database/migrations')
        ], 'migrations');
    }

    /**
     * Register the commands
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
