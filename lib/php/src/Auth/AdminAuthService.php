<?php

namespace Ridibooks\Cms\Auth;

use Ridibooks\Cms\Thrift\AdminAuth\AdminAuthServiceClient;
use Ridibooks\Cms\Thrift\AdminAuth\TokenClaim;
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
            $admin_id = LoginService::authenticate();

            $client = ThriftService::getHttpClient('AdminAuth');
            $client->authorizeAdminByUrl(
                $admin_id,
                $request->getRequestUri()
            );
        } catch (NoTokenException $e) {
            return self::createRedirectToAuthorize($request->getRequestUri());
        } catch (MalformedTokenException $e) {
            return self::createRedirectToAuthorize($request->getRequestUri());
        } catch (ExpiredTokenException $e) {
            return self::createRedirectToAuthorize($request->getRequestUri());
        } catch (UnauthorizedException $e) {
            if ($request->isXmlHttpRequest()) {
                return new Response($e->getMessage(), Response::HTTP_UNAUTHORIZED);
            } else { //일반 페이지
                return new Response(UrlHelper::printAlertHistoryBack($e->getMessage()));
            }
        }

        return null;
    }

    public static function authorizeByTag($token, array $tags)
    {
        $request = Request::createFromGlobals();

        try {
            $admin_id = LoginService::authenticate();

            $client = ThriftService::getHttpClient('AdminAuth');
            $client->authorizeAdminByTag($admin_id, $tags);
        } catch (NoTokenException $e) {
            return self::createRedirectToAuthorize($request->getRequestUri());
        } catch (MalformedTokenException $e) {
            return self::createRedirectToAuthorize($request->getRequestUri());
        } catch (ExpiredTokenException $e) {
            return self::createRedirectToAuthorize($request->getRequestUri());
        } catch (UnauthorizedException $e) {
            return new Response($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }

        return null;
    }

    private static function createRedirectToAuthorize(string $return_url)
    {
        $redirect_url = '/auth/oauth2/authorize?return_url=' . urlencode($return_url);

        return RedirectResponse::create($redirect_url);
    }

    /**
     * @throws NoTokenException
     * @throws MalformedTokenException
     */
    public static function introspectToken($token): array
    {
        $client = ThriftService::getHttpClient('AdminAuth');
        /** @var TokenClaim */
        $token_claim = $client->introspectToken($token);

        return (array) $token_claim;
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
