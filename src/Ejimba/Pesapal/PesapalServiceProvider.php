<?php namespace Ejimba\Pesapal;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class PesapalServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('ejimba/pesapal');
		include __DIR__.'/../../routes.php';
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		AliasLoader::getInstance()->alias('Pesapal', 'Ejimba\Pesapal\Facades\Pesapal');
		$this->app->bind('pesapal', function ()
        {
        	return new Pesapal;
        });
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
