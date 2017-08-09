<?php

use Ridibooks\Cms\Thrift\ThriftService;
use Ridibooks\Platform\Cms\Auth\LoginService;
use Ridibooks\Platform\Cms\CmsApplication;

$autoloader = require_once __DIR__ . "/../vendor/autoload.php";
$autoloader->addPsr4('Ridibooks\\Cms\\Test\\', __DIR__ . '/../src');

// Load a env file.
if (is_readable(__DIR__ . '/../.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__, '/../.env');
    $dotenv->load();
}

// Start a session.
$session_domain = $_ENV['SESSION_DOMAIN'];
$couchbase_host = $_ENV['COUCHBASE_HOST'];
$memcache_host = $_ENV['MEMCACHE_HOST'];

if (!empty($memcache_host)) {
    LoginService::startMemcacheSession($memcache_host, $session_domain);
} elseif (!empty($couchbase_host)) {
    LoginService::startCouchbaseSession(explode(',', $couchbase_host), $session_domain);
} else {
    LoginService::startSession($session_domain);
}

// Set rpc endpoint.
if (!empty($_ENV['CMS_RPC_URL'])) {
    ThriftService::setEndPoint($_ENV['CMS_RPC_URL']);
}

$app = new CmsApplication();

// Add some Silex service providers you need here.

$app['debug'] = $_ENV['DEBUG'];
$app['twig.path'] = __DIR__ . '/../view/';
return $app;
