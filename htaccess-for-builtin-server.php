<?php

if (preg_match('/\.(css|js|html|png)/', $_SERVER['REQUEST_URI'])) {
	return false ;       // serve requested file as is
} else {
	require 'index.php'; // create, initiate and start router object
}
