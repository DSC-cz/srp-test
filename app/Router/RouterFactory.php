<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): RouteList
	{
		$router = new RouteList;
		$router->addRoute('/', 'Front:Login:default');
		$router->addRoute('/logout', 'Front:Logout:default');
		$router->addRoute('/dashboard', 'Dashboard:Dashboard:dashboard');
		$router->addRoute('/brands/<action>[/<id>]', 'Brands:Brand:brands');
		return $router;
	}
}
