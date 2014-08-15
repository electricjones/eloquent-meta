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
        $this->package('Phoenix/meta');

        $this->app->bind(
            'phoenix.metable',
            'Phoenix\EloquentMeta\CreateMetaTableCommand');

		// $this->app->register('Way\Generators\GeneratorsServiceProvider');

        $this->commands('phoenix.metable');
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
