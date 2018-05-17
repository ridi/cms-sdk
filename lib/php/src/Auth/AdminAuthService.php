<?php

namespace Ridibooks\Cms\Auth;

use Ridibooks\Cms\Thrift\AdminAuth\AdminAuthServiceClient;
use Ridibooks\Cms\Thrift\AdminAuth\AccessToken;
use Ridibooks\Cms\Thrift\Errors\ExpiredTokenException;
use Ridibooks\Cms\Thrift\Errors\MalformedTokenException;
use Ridibooks\Cms\Thrift\Errors\NoTokenException;
use Ridibooks\Cms\Thrift\Errors\UnauthorizedException;
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

    /**
     * @param Request $request
     * @return null|Response
     */
    public static function authorize($request)
    {
        try {
            $token = LoginService::getAccessToken();

            $client = ThriftService::getHttpClient('AdminAuth');
            $client->authorize(
                $token,
                [$request->getMethod()],
                $request->getRequestUri()
            );
        } catch (NoTokenException $e) {
            $redirect_url = '/authorize?return_url=' . urlencode($request->getRequestUri());
            return RedirectResponse::create($redirect_url);
        } catch (MalformedTokenException $e) {
            $redirect_url = '/authorize?return_url=' . urlencode($request->getRequestUri());
            return RedirectResponse::create($redirect_url);
        } catch (ExpiredTokenException $e) {
            $redirect_url = '/authorize?return_url=' . urlencode($request->getRequestUri());
            return RedirectResponse::create($redirect_url);
        } catch (UnauthorizedException $e) {
            if ($request->isXmlHttpRequest()) {
                return new Response($e->getMessage(), Response::HTTP_UNAUTHORIZED);
            } else { //일반 페이지
                return new Response(UrlHelper::printAlertHistoryBack($e->getMessage()));
            }
        }

        return null;
    }

    /**
     * @throws NoTokenException
     * @throws MalformedTokenException
     */
    public static function introspectToken($token): array
    {
        $client = ThriftService::getHttpClient('AdminAuth');
        /** @var AccessToken */
        $auth_token = $client->introspectToken($token);

        return (array) $auth_token;
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

        /** @var AdminAuthServiceClient $client */
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

        /** @var AdminAuthServiceClient $client */
        $client = ThriftService::getHttpClient('AdminAuth');
        $hash_array = $client->getCurrentHashArray($check_url, LoginService::GetAdminID());

        return $hash_array;
    }

    /**적합한 유저인지 검사한다.
     * @return bool
     */
    public static function isValidUser()
    {
        $admin = AdminUserService::getUser(LoginService::GetAdminID());
        return $admin && $admin['is_use'];
    }
}
