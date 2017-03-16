<?php

namespace Ridibooks\Platform\Cms;

use Ridibooks\Platform\Cms\Auth\LoginService;
use Silex\Api\ControllerProviderInterface;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class LoginControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controller_collection = $app['controllers_factory'];
        $controller_collection->get('/', [$this, 'index']);
        $controller_collection->get('/welcome', [$this, 'getWelcomePage']);
        $controller_collection->get('/login', [$this, 'getLoginPage']);
        $controller_collection->get('/logout', [$this, 'logout']);
        return $controller_collection;
    }

    public function index(CmsApplication $app)
    {
        return $app->redirect('/welcome');
    }

    public function getWelcomePage(CmsApplication $app)
    {
        return $app->render('welcome.twig');
    }

    public function getLoginPage(Request $request, CmsApplication $app)
    {
        LoginService::resetSession();

        $cms = $app['cms'];
        $login_endpoint = $cms['url'] . $cms['login_path'];
        $return_path = $request->get('return_url');

        $end_point = LoginService::getLoginPageUrl($login_endpoint, $return_path);

        return $app->redirect($end_point);
    }

    public function logout()
    {
        LoginService::resetSession();
        return RedirectResponse::create('/');
    }
}
