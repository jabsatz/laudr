<?php namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Laud as Laud;
use App\User as User;

class RouteServiceProvider extends ServiceProvider {

	/**
	 * This namespace is applied to the controller routes in your routes file.
	 *
	 * In addition, it is set as the URL generator's root namespace.
	 *
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function boot(Router $router)
	{
		parent::boot($router);

    //Accept requests with token in the 'X-CSRF-Token' header (for ajax).
    $router->filter('crsf', function() {
      $token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
      if (Session::token() != $token) throw new Illuminate\Session\TokenMismatchException;
    });

    $router->bind('laud', function($id){
      return Laud::with('user')->find($id);
    });
    $router->bind('user', function($id){
      return User::with('lauds')->find($id);
    });

	}

	/**
	 * Define the routes for the application.
	 *
	 * @param  \Illuminate\Routing\Router  $router
	 * @return void
	 */
	public function map(Router $router)
	{
		$router->group(['namespace' => $this->namespace], function($router)
		{
			require app_path('Http/routes.php');
		});
	}

}
