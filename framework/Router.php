<?php

namespace framework;

use app\Config; // @thodo: dependency injection
use framework\AlgebraicDataTypes\Maybe;

class Router
{
	private $routes;
	private $request;
	/** Cached properties from $request: */
	private $method, $uri;

	public function __construct($routes, $request)
	{
		$this->routes  = $routes;
		$this->request = $request;
		/** Cache: */
		$this->method  = $request->method();
		$this->uri     = $request->uri();
		/** Debug: */
		if (Config::DEBUG) echo '[' . $this->method . ' ' . $this->uri . '] ';
	}

	public function routeOrReport()
	{
		$matched = $this->route();
		if (!$matched) {
			printf("Request `%s %s` does not match any routes\n", $this->method, $this->uri);
		}
	}

	private function route()
	{
		foreach ($this->routes as $sluggedUri => $uriFunctionalities) {
			foreach ($uriFunctionalities as $method => $controllerAction) {
				$matched = $this->executeIfMatching($method, $sluggedUri, $controllerAction);
				if ($matched) {
					return true;
				}
			}
		}
		return false;
	}

	private function executeIfMatching($method, $sluggedUri, $controllerAction)
	{
		$maybeArgs = $this->match($method, $sluggedUri);
		$request = $this->request; // only for < PHP-5.4, see http://php.net/manual/en/functions.anonymous.php#example-167
		return $maybeArgs->maybe(
			function () {return false;},
			function ($args) use ($controllerAction, $request) // ... in >= PHP 5.4, you do not need to pass `$request`...
			{
				list($controllerClass, $action, $paramTypes) = $controllerAction;
				$controller = new $controllerClass($request); // ... instead, You can use `$this->request` here.
				foreach ($args as $i => $arg) {
					$typeCaster = $paramTypes[$i]; // `intval` or `strval`
					$args[$i] = $typeCaster($arg);
				}
				call_user_func_array(array($controller, $action), $args);
				return true;
			}
		);
	}

	private function match($method, $sluggedUri)
	{
		$methodsMatched = $method == $this->method;
		$urisMatched    = preg_match("!^$sluggedUri$!", $this->uri, $matches);
		if ($methodsMatched && $urisMatched) {
			array_shift($matches);
			return Maybe::just($matches);
		} else {
			return Maybe::nothing();
		}
	}
}
