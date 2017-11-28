
<?php

use Ridibooks\Cms\Example\Controller\MyController;
use Ridibooks\Platform\Cms\CmsApplication;
use Ridibooks\Platform\Cms\MiniRouter;
use Symfony\Component\HttpFoundation\Request;

// Check an auth.
$app->before(function (Request $request) {
    return MiniRouter::shouldRedirectForLogin($request);
});

$app->get('/example/home', function (CmsApplication $app) {
    return $app['twig']->render('home.twig', [
        'name' => $_SESSION['session_admin_id']
    ]);
});

$app->mount('/example', new MyController());
