<?php

namespace Ridibooks\Cms\Auth;

use GuzzleHttp\Client;
use Ridibooks\Cms\Thrift\ThriftService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginService
{
    const ADMIN_ID_COOKIE_NAME = 'admin-id';
    const TOKEN_COOKIE_NAME = 'cms-token';

    private static $login_context;

    /**
     * @param string $id
     * @param string $passwd
     * @throws \Exception
     */
    public static function doLoginAction($id, $passwd)
    {
        self::checkUserPassword($id, $passwd);
    }

    /**
     * @param string $id
     * @param string $passwd
     * @throws \Exception
     */
    public static function checkUserPassword($id, $passwd)
    {
        $user = AdminUserService::getUser($id);
        if (!$user || $user['is_use'] != '1') {
            throw new \Exception('잘못된 계정정보입니다.');
        }

        if (!PasswordService::isPasswordMatchToHashed($passwd, $user['passwd'])) {
            throw new \Exception('비밀번호가 맞지 않습니다.');
        }

        if (PasswordService::needsRehash($user['passwd'])) {
            AdminUserService::updatePassword($id, $passwd);
        }
    }

    public static function doCmsLoginAction($id)
    {
        $user = AdminUserService::getUser($id);
        if (!$user || $user['is_use'] != '1') {
            throw new \Exception('ID와 일치하는 계정이 없습니다. 관리자에게 문의하세요.');
        }
    }

    public static function getLoginPageUrl($login_endpoint, $return_path)
    {
        $scheme = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        if ($return_path[0] != '/') {
            $return_path = '/' . $return_path;
        }
        $callback_path = $scheme . '://' . $host . $return_path;
        return $login_endpoint . '?return_url=' . urlencode($callback_path);
    }

    public static function GetAdminID()
    {
        return self::$login_context->user_id ?? ($_COOKIE[self::ADMIN_ID_COOKIE_NAME] ?? null);
    }

    private static function getRPCUrl()
    {
        $endpoint = ThriftService::getEndPoint();
        $endpoint = rtrim($endpoint, '/');

        return $endpoint;
    }

    public static function requestTokenIntrospect($token)
    {
        $client = new Client(['verify' => false]);
        $response = $client->post(self::getRPCUrl() . '/token-introspect', [
            'http_errors' => false,
            'form_params' => [
                'token' => $token,
            ],
        ]);

        return json_decode($response->getBody());
    }

    public static function isAuthRequired(request $request)
    {
        $open_urls = [
            '/token-introspect', // Token validation url
            '/token-refresh',
            '/login',
            '/logout',
        ];

        return in_array($request->getPathInfo(), $open_urls) ? false : true;
    }

    public static function validateLogin(request $request)
    {
        $token = $request->cookies->get(self::TOKEN_COOKIE_NAME);
        if (empty($token)) {
            return false;
        }

        self::$login_context = self::requestTokenIntrospect($token);

        return isset(self::$login_context->user_id);
    }

    private static function isTokenExpired()
    {
        return isset(self::$login_context->error) && self::$login_context->error === 'Authentication_ExpiredToken';
    }

    public static function createRedirectForLogin(request $request)
    {
        $request_uri = $request->getRequestUri();

        if (self::isTokenExpired()) {
            $redirect_url = self::getRPCUrl() . '/token-refresh';
        } else {
            $redirect_url = '/login';
        }

        if ($request_uri !== '/login' && $request_uri !== '/logout') {
            $redirect_url .= '?return_url=' . urlencode($request->getRequestUri());
        }

        return RedirectResponse::create($redirect_url);
    }

    public static function setLoginContext($login_context)
    {
        self::$login_context = (object)$login_context;
    }
}
