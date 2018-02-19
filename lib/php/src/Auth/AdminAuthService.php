<?php

namespace Ridibooks\Cms\Auth;

use GuzzleHttp\Client;
use Ridibooks\Cms\Thrift\ThriftService;
use Ridibooks\Cms\Util\UrlHelper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**권한 설정 Service
 * @deprecated
 */
class AdminAuthService
{
    /**해당 유저가 볼 수 있는 메뉴를 가져온다.
     * @return array
     */
    public function getAdminMenu()
    {
        $client = ThriftService::getHttpClient('AdminAuth');
        $admin_id = LoginService::GetAdminID();
        if (empty($admin_id)) {
            return [];
        }
        return $client->getAdminMenu($admin_id);
    }

    /**해당 유저의 태그 ID 가져온다.
     * @return array
     */
    public function getAdminTagId()
    {
        return AdminUserService::getAdminUserTag(LoginService::GetAdminID());
    }

    /**해당 URL에 접근할 권한이 있는지 검사한다.<br/>
     * 문제점
     * - 각 menu 밑에 sub url 검사를 한번 더 하는데 의존관계를 알기 힘들다.
     * - 현재는 여러 페이지에서 사용하는 ajax_url의 권한을 확실하게 하지 못한다.
     * - 나중에 권한을 좀 더 세분화 시킬때는 sub url을 unique키로 하여 각 sub url의 진입점을 구분하도록 메뉴주소를 따로 구분하는게 좋을것 같다.
     * @param null $method
     * @param null $check_url
     * @throws
     */
    public static function hasUrlAuth($method = null, $check_url = null)
    {
        if (class_exists('Config')) {
            $is_dev = \Config::$UNDER_DEV;
        } else {
            $is_dev = $_ENV['DEBUG'];
        }

        if (!self::hasHashAuth($method, $check_url) && !$is_dev) {
            throw new \Exception("해당 권한이 없습니다.");
        }
    }

    /**해당 URL의 Hash 권한이 있는지 검사한다.<br/>
     * @param null $hash
     * @param null $check_url
     * @return bool
     */
    public static function hasHashAuth($hash = null, $check_url = null)
    {
        if (!isset($check_url) || trim($check_url) === '') {
            $check_url = $_SERVER['REQUEST_URI'];
        }

        $client = ThriftService::getHttpClient('AdminAuth');
        return $client->hasHashAuth($hash, $check_url, LoginService::GetAdminID());
    }

    /**해당 URL의 Hash 권한 Array를 반환한다.
     * @param null $check_url
     * @return array $hash_array
     */
    public static function getCurrentHashArray($check_url = null)
    {
        if (!isset($check_url) || trim($check_url) === '') {
            $check_url = $_SERVER['REQUEST_URI'];
        }

        $client = ThriftService::getHttpClient('AdminAuth');
        $hash_array = $client->getCurrentHashArray($check_url, LoginService::GetAdminID());

        return $hash_array;
    }

    public static function requestTokenIntrospect($token)
    {
        $client = new Client(['verify' => false]);
        $response = $client->post(self::getTokenIntrospectUrl(), [
            'form_params' => [
                'token' => $token,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        return json_decode($response->getBody());
    }

    private static function getTokenIntrospectUrl()
    {
        $endpoint = ThriftService::getEndPoint();
        $endpoint = rtrim($endpoint, '/');

        return $endpoint . '/token-introspect';
    }

    /**적합한 유저인지 검사한다.
     * @return bool
     */
    public static function isValidUser()
    {
        $admin = AdminUserService::getUser(LoginService::GetAdminID());
        return $admin && $admin['is_use'];
    }

    /**
     * @param Request $request
     * @return null|Response
     */
    public static function authorize($request)
    {
        $is_whitelisted = in_array($request->getRequestUri(), [
            '/token-introspect', // Token validation url, which is called in this function.
            '/login',
            '/logout',
        ]);
        if ($is_whitelisted) {
            return null;
        }

        $request_uri = $request->getRequestUri();
        if (!LoginService::validateLogin($request)) {
            $login_url = '/login';
            if (!empty($request_uri) && $request_uri != '/login' && $request_uri != '/logout') {
                $login_url .= '?return_url=' . urlencode($request_uri);
            }

            return RedirectResponse::create($login_url);
        }

        try {
            self::hasUrlAuth(null, $request_uri);
        } catch (\Exception $e) {
            // 이상하지만 기존과 호환성 맞추기 위해
            if ($request->isXmlHttpRequest()) {
                return new Response($e->getMessage());
            } else { //일반 페이지
                return new Response(UrlHelper::printAlertHistoryBack($e->getMessage()));
            }
        }

        return null;
    }
}
