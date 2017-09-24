<?php

namespace app;

use app\Controller\GalleryController;
use app\Controller\NewController;
use app\Controller\BackendAppController;

class Routes
{
	const NO_MATCH_FORMAT = "Request `%s %s` does not match any routes!";
	const NO_MATCH_REGEXP = "!Request `(GET|POST) (.+)` does not match any routes!";

	const IS_DIRECT_TEXT = true;
	const IS_FILENAME    = false;

	/** PHP 7: const CONFIG = [...] */
	public static $CONFIG = array(
		'/'                            => array('GET'  => array(GalleryController::class54,    'devPortal',     array(),                     )), // index
		'/dev-portal'                  => array('GET'  => array(GalleryController::class54,    'devPortal',     array(),                     )),
		'/home'                        => array('GET'  => array(NewController::class54,        'index',         array(),                     )),
		'/samples'                     => array('GET'  => array(GalleryController::class54,    'samples',       array(),                     )),
		'/focus/([0-9]+)/([0-9]+)'     => array('GET'  => array(GalleryController::class54,    'show',          array('intval', 'intval')    )),
		'/focus2/([0-9]+)/([0-9]+)'    => array('GET'  => array(NewController::class54,        'show2',         array('intval', 'intval')    )),
		'/focus-js/([0-9]+)/([0-9]+)'  => array('GET'  => array(GalleryController::class54,    'showJs',        array('intval', 'intval')    )),
		'/focus2-js/([0-9]+)/([0-9]+)' => array('GET'  => array(NewController::class54,        'show2Js',       array('intval', 'intval')    )),
		'/xfocus-js/([0-9]+)/([0-9]+)' => array('GET'  => array(BackendAppController::class54, 'xshowJs',       array('intval', 'intval')    )),
		'/dompag'                      => array('GET'  => array(GalleryController::class54,    'domPagination', array()                      ))
	);

	/** PHP RFC: const TESTCASES = [...] --- immutable objects are yet RFC, see https://wiki.php.net/rfc/immutability */
	public static function TESTCASES()
	{
		return array(
			'GI'  => array(
						'fixture'     => array(array('GET',  '/'               ), array(), array()                             ),
						'expectation' => Maybe::just(array(self::IS_FILENAME, 'GET.html'))
			),
			'PI'  => array(
						'fixture'     => array(array('POST', '/'               ), array(), array()                             ),
						'expectation' => Maybe::nothing()
			),
			'GS'  => array(
						'fixture'     => array(array('GET',  '/student'        ), array(), array()                             ),
						'expectation' => Maybe::just(array(self::IS_FILENAME, 'GET-student.html'))
			),
			'PS'  => array(
						'fixture'     => array(array('POST', '/student'        ), array(), array()                             ),
						'expectation' => Maybe::nothing()
			),
			'GS1' => array(
						'fixture'     => array(array('GET',  '/student/2'     ), array(), array()                              ),
						'expectation' => Maybe::just(array(self::IS_FILENAME, 'GET-student-2.html'))
			),
			'GS0' => array(
						'fixture'     => array(array('GET',  '/student/'       ), array(), array()                             ),
						'expectation' => Maybe::nothing()
			),
			'GS_' => array(
						'fixture'     => array(array('GET',  '/student/1a2'    ), array(), array()                             ),
						'expectation' => Maybe::nothing()
			),
			'PS1' => array(
						'fixture'     => array(array('POST', '/student/2'     ), array(), array('name' => 'Joan', 'email' => 'joan@it.us')),
						'expectation' => Maybe::just(array(self::IS_DIRECT_TEXT, ''))
			),
			'GS2' => array(
						'fixture'     => array(array('GET',  '/student/2'     ), array(), array()                              ),
						'expectation' => Maybe::just(array(self::IS_FILENAME, 'GET-student-22.html'))
			),
			'PS2' => array(
						'fixture'     => array(array('POST', '/student/2'     ), array(), array('name' => 'Joe', 'is_male' => 'on', 'email' => 'joe@it.us')),
						'expectation' => Maybe::just(array(self::IS_DIRECT_TEXT, ''))
			),
			'GS3' => array(
						'fixture'     => array(array('GET',  '/student/2'     ), array(), array()                              ),
						'expectation' => Maybe::just(array(self::IS_FILENAME, 'GET-student-2.html'))
			),
			'PS0' => array(
						'fixture'     => array(array('POST', '/student/'       ), array(), array()                             ),
						'expectation' => Maybe::nothing()
			),
			'PS_' => array(
						'fixture'     => array(array('POST', '/student/1a2'    ), array(), array()                             ),
						'expectation' => Maybe::nothing()
			),
			'GN'  => array(
						'fixture'     => array(array('GET',  '/nonexisting'    ), array(), array()                             ),
						// builtin server passes it to index, even if no router file test
						'expectation' => Maybe::nothing()
			),
			'GNE' => array(
						'fixture'     => array(array('POST', '/nonexisting.php'), array(), array()                             ),
						// builtin server tries to serve it as a file
						'expectation' => Maybe::nothing()
			),
			'IPA' => array(
						'fixture'     => array(array('GET',  '/index.php/aaa'  ), array(), array()                             ),
						// builtin server tries to serve it as a file
						'expectation' => Maybe::nothing()
			),
		);
	}

}
