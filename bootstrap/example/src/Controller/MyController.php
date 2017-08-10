<?php

namespace Ridibooks\Cms\Test\Controller;

use Ridibooks\Platform\Cms\CmsApplication;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class MyController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controller_collection = $app['controllers_factory'];

        $controller_collection->get('/resource1', [$this, 'getResource1']);
        $controller_collection->get('/resource2', [$this, 'getResource2']);

        return $controller_collection;
    }

    public function getResource1(CmsApplication $app)
    {
        return $app->render('resource1.twig');
    }

    public function getResource2(CmsApplication $app)
    {
        return $app->render('resource2.twig');
    }
}
