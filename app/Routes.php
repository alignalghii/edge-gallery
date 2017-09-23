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
	public static $CONFIG = [
		'/'                            => ['GET'  => [GalleryController::class54,    'devPortal',     [],                     ]], // index
		'/dev-portal'                  => ['GET'  => [GalleryController::class54,    'devPortal',     [],                     ]],
		'/home'                        => ['GET'  => [NewController::class54,        'index',         [],                     ]],
		'/samples'                     => ['GET'  => [GalleryController::class54,    'samples',       [],                     ]],
		'/focus/([0-9]+)/([0-9]+)'     => ['GET'  => [GalleryController::class54,    'show',          ['intval', 'intval']    ]],
		'/focus2/([0-9]+)/([0-9]+)'    => ['GET'  => [NewController::class54,        'show2',         ['intval', 'intval']    ]],
		'/focus-js/([0-9]+)/([0-9]+)'  => ['GET'  => [GalleryController::class54,    'showJs',        ['intval', 'intval']    ]],
		'/focus2-js/([0-9]+)/([0-9]+)' => ['GET'  => [NewController::class54,        'show2Js',       ['intval', 'intval']    ]],
		'/xfocus-js/([0-9]+)/([0-9]+)' => ['GET'  => [BackendAppController::class54, 'xshowJs',       ['intval', 'intval']    ]],
		'/dompag'                      => ['GET'  => [GalleryController::class54,    'domPagination', []                      ]]
	];

	/** PHP RFC: const TESTCASES = [...] --- immutable objects are yet RFC, see https://wiki.php.net/rfc/immutability */
	public static function TESTCASES()
	{
		return [
			'GI'  => [
						'fixture'     => [['GET',  '/'               ], [], []                             ],
						'expectation' => Maybe::just([self::IS_FILENAME, 'GET.html'])
			],
			'PI'  => [
						'fixture'     => [['POST', '/'               ], [], []                             ],
						'expectation' => Maybe::nothing()
			],
			'GS'  => [
						'fixture'     => [['GET',  '/student'        ], [], []                             ],
						'expectation' => Maybe::just([self::IS_FILENAME, 'GET-student.html'])
			],
			'PS'  => [
						'fixture'     => [['POST', '/student'        ], [], []                             ],
						'expectation' => Maybe::nothing()
			],
			'GS1' => [
						'fixture'     => [['GET',  '/student/2'     ], [], []                              ],
						'expectation' => Maybe::just([self::IS_FILENAME, 'GET-student-2.html'])
			],
			'GS0' => [
						'fixture'     => [['GET',  '/student/'       ], [], []                             ],
						'expectation' => Maybe::nothing()
			],
			'GS_' => [
						'fixture'     => [['GET',  '/student/1a2'    ], [], []                             ],
						'expectation' => Maybe::nothing()
			],
			'PS1' => [
						'fixture'     => [['POST', '/student/2'     ], [], ['name' => 'Joan', 'email' => 'joan@it.us']],
						'expectation' => Maybe::just([self::IS_DIRECT_TEXT, ''])
			],
			'GS2' => [
						'fixture'     => [['GET',  '/student/2'     ], [], []                              ],
						'expectation' => Maybe::just([self::IS_FILENAME, 'GET-student-22.html'])
			],
			'PS2' => [
						'fixture'     => [['POST', '/student/2'     ], [], ['name' => 'Joe', 'is_male' => 'on', 'email' => 'joe@it.us']],
						'expectation' => Maybe::just([self::IS_DIRECT_TEXT, ''])
			],
			'GS3' => [
						'fixture'     => [['GET',  '/student/2'     ], [], []                              ],
						'expectation' => Maybe::just([self::IS_FILENAME, 'GET-student-2.html'])
			],
			'PS0' => [
						'fixture'     => [['POST', '/student/'       ], [], []                             ],
						'expectation' => Maybe::nothing()
			],
			'PS_' => [
						'fixture'     => [['POST', '/student/1a2'    ], [], []                             ],
						'expectation' => Maybe::nothing()
			],
			'GN'  => [
						'fixture'     => [['GET',  '/nonexisting'    ], [], []                             ],
						// builtin server passes it to index, even if no router file test
						'expectation' => Maybe::nothing()
			],
			'GNE' => [
						'fixture'     => [['POST', '/nonexisting.php'], [], []                             ],
						// builtin server tries to serve it as a file
						'expectation' => Maybe::nothing()
			],
			'IPA' => [
						'fixture'     => [['GET',  '/index.php/aaa'  ], [], []                             ],
						// builtin server tries to serve it as a file
						'expectation' => Maybe::nothing()
			],
		];
	}

}
