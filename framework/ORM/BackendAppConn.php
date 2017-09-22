<?php

namespace framework\ORM;

use app\Config;

class BackendAppConn
{
	private $params;
	public function __construct($params) {$this->params = $params;}

	public function fillInUrl()
	{
		$url = Config::BACKENDAPP_URL;
		foreach (Config::$BACKENDAPP_PARAMS as $paramName => $placeholder) {
			$url = preg_replace("/$placeholder/", $this->params[$paramName], $url);
		}
		return $url;
	}

	public function get()
	{
		$url = $this->fillInUrl();
		ob_start();
			$ch = \curl_init($url);
				\curl_exec($ch);
			\curl_close($ch);
		return ob_get_clean();
	}
}
