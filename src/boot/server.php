#!/usr/bin/env php
<?php
/**
 * @var Container $di
 * @var \Inhere\Library\Collections\Configuration $config
 * @var AppServer $server
 * @var App $app
 * @usage `php bin/server start|stop|...`
 */

use Inhere\Http\ServerRequest;
use Inhere\Http\Uri;
use Inhere\Library\DI\Container;
use LightCms\Web\App;
use LightCms\Web\AppServer;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('RUNTIME_ENV', $config->get('env'));
define('APP_DEBUG', $config->get('debug'));

// create app server.
$server = $di->get('server');

$server->on(AppServer::ON_BOOTSTRAP, function ($svr) {
    // load ws modules
//    require dirname(__DIR__) . '/app/Ws/modules.php';
});

$server->on(AppServer::ON_SERVER_CREATE, function () {
  // prepare load classes
//  $req = new Request('GET', Uri::createFromString('/'));
//  $res = HttpHelper::createResponse();
    require __DIR__ . '/web.php';
});

// 启动worker 后，再初始化应用(加载应用配置、路由 ...)
$server->on(AppServer::ON_WORKER_STARTED, function (AppServer $server) {
    /** @var App $app */
    $app = \Sys::$di->get('app');
    $server->setApp($app);

    // load http routes
    require dirname(__DIR__) . '/app/Http/routes.php';

    // collect and parse annotations
    require dirname(__DIR__) . '/app/annotations.php';

    // load ws modules
    require dirname(__DIR__) . '/app/Ws/modules.php';

    $app->run();
});

//require dirname(__DIR__) . '/app/annotations.php';
//exit;

$server->run();

//$app = $di->get('app');
//$app->run();
