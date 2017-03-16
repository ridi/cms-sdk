<?php

namespace Ridibooks\Platform\Cms;

use Ridibooks\Library\UrlHelper;
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

    public function index(Request $request, CmsApplication $app)
    {
        return $app->redirect('/welcome');
    }

    public function getWelcomePage(Request $request, CmsApplication $app)
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

    public function loginWithCms(Request $request, CmsApplication $app)
    {
        $id = $request->get('id');
        $passwd = $request->get('passwd');
        $return_url = $request->get('return_url', '/welcome');

        try {
            LoginService::doLoginAction($id, $passwd);
            return RedirectResponse::create($return_url);
        } catch (\Exception $e) {
            return UrlHelper::printAlertRedirect('/login?return_url=' . urlencode($return_url), $e->getMessage());
        }
    }

    private function decodeResource($resource, $key)
    {
        $method = 'aes-256-ctr';
        $nonceSize = openssl_cipher_iv_length($method);
        $nonce = mb_substr($resource, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($resource, $nonceSize, null, '8bit');
        return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $nonce);
    }

    public function logout(Request $request, CmsApplication $app)
    {
        LoginService::resetSession();
        return RedirectResponse::create('/');
    }
}
