<?php

// load required files
require_once __DIR__ . '/app/app.php';
require_once __DIR__ . '/app/config.php';
require_once __DIR__ . '/app/autoload.php';
require_once __DIR__ . '/app/enums/status.php';
require_once __DIR__ . '/app/enums/type.php';
spl_autoload_register('my_autoloader_function');

//init F3
if (file_exists('vendor/autoload.php')) {
	// load via composer
	require_once('vendor/autoload.php');
	$f3 = \F3::instance();
} elseif (!file_exists('lib/base.php')) {
	die('fatfree-core not found. Run `git submodule init` and `git submodule update` or install via composer with `composer install`.');
} else {
	// load via submodule
	/** @var Base $f3 */
	$f3 = require('lib/base.php');
}


$f3->set('DEBUG', 3);
if ((float)PCRE_VERSION < 8.0)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('config.ini');

// Include API routes
include('routes/api.php');

$f3->route(
	'GET /',
	function ($f3) {
		$classes = array(
			'Base' =>
			array(
				'hash',
				'json',
				'session',
				'mbstring'
			),
			'Cache' =>
			array(
				'apc',
				'apcu',
				'memcache',
				'memcached',
				'redis',
				'wincache',
				'xcache'
			),
			'DB\SQL' =>
			array(
				'pdo',
				'pdo_dblib',
				'pdo_mssql',
				'pdo_mysql',
				'pdo_odbc',
				'pdo_pgsql',
				'pdo_sqlite',
				'pdo_sqlsrv'
			),
			'DB\Jig' =>
			array('json'),
			'DB\Mongo' =>
			array(
				'json',
				'mongo'
			),
			'Auth' =>
			array('ldap', 'pdo'),
			'Bcrypt' =>
			array(
				'openssl'
			),
			'Image' =>
			array('gd'),
			'Lexicon' =>
			array('iconv'),
			'SMTP' =>
			array('openssl'),
			'Web' =>
			array('curl', 'openssl', 'simplexml'),
			'Web\Geo' =>
			array('geoip', 'json'),
			'Web\OpenID' =>
			array('json', 'simplexml'),
			'Web\OAuth2' =>
			array('json'),
			'Web\Pingback' =>
			array('dom', 'xmlrpc'),
			'CLI\WS' =>
			array('pcntl')
		);
		$f3->set('classes', $classes);
		$f3->set('content', 'welcome.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->route(
	'GET /userref',
	function ($f3) {
		$f3->set('content', 'userref.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->run();
