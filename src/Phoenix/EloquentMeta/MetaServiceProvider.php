<?php namespace Phoenix\EloquentMeta;

use Illuminate\Support\ServiceProvider;

class MetaServiceProvider extends ServiceProvider {

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
        $this->package('scubaclick/meta');

        $this->app->bind(
            'scubaclick.metable',
            'Phoenix\Meta\CreateMetaTableCommand');

		// $this->app->register('Way\Generators\GeneratorsServiceProvider');

        $this->commands('scubaclick.metable');
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
		return array();
	}

}
