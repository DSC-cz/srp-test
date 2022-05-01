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
		$router->withModule('Global');
		$router->addRoute('/[/<action=default>]', 'Users:Login:default');
		$router->addRoute('/logout[/<action=default>]', 'Users:Logout:default');
		$router->addRoute('/users[/<action=list>][/<page=1>]/', 'Users:User:list');
		$router->addRoute('/dashboard[/<action=default>]', 'Dashboard:Dashboard:default');
		$router->addRoute('/brands[/<action=list>][/<page=1>]/', 'Brands:Brand:brands');
		return $router;
	}
}
