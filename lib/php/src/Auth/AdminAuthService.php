<?php

namespace Ridibooks\Cms\Auth;

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
    private $adminAuth; //권한이 있는 메뉴 array
    private $adminMenu; //권한이 없는 순수 메뉴 array
    private $adminTag; //로그인 한 유저의 Tag Array

    public function __construct()
    {
        $this->initAdminMenu();
        $this->initAdminTag();
    }

    /**해당 유저의 메뉴를 셋팅한다.
     */
    private function initAdminMenu()
    {
        $admin_menu = [];
        $user_menus = AdminUserService::getAdminUserMenu(LoginService::GetAdminID());
        foreach ($user_menus as $menu) {
            if ($menu['is_use'] == 1 && $menu['is_show'] == 1) {
                $admin_menu[$menu['id']] = $menu;
            }
        }
        $this->adminMenu = $admin_menu;
    }

    /**해당 유저의 태그를 셋팅한다.
     */
    private function initAdminTag()
    {
        $this->adminTag = AdminUserService::getAdminUserTag(LoginService::GetAdminID());
    }

    /**해당 유저의 모든 권한을 가져온다.
     * @return array
     */
    public function getAdminAuth()
    {
        return $this->adminAuth;
    }

    /**해당 유저가 볼 수 있는 메뉴를 가져온다.
     * @return array
     */
    public function getAdminMenu()
    {
        return $this->adminMenu;
    }

    /**해당 유저의 모든 태그를 가져온다.
     * @return array
     */
    public function getAdminTag()
    {
        return $this->adminTag;
    }

    /**해당 유저의 태그 ID 가져온다.
     * @return array
     */
    public function getAdminTagId()
    {
        $session_user_tagid = [];
        foreach ($_SESSION['session_user_tag'] as $tag) {
            $session_user_tagid[] = $tag;
        }
        return $session_user_tagid;
    }

    /**적합한 로그인 상태인지 검사한다.
     * @return bool
     */
    public static function isValidLogin()
    {
        return LoginService::GetAdminID()
            && isset($_SESSION['session_user_auth']) && isset($_SESSION['session_user_menu']);
    }

    /**적합한 유저인지 검사한다.
     * @return bool
     */
    public static function isValidUser()
    {
        $admin = AdminUserService::getUser(LoginService::GetAdminID());
        return $admin && $admin['is_use'];
    }

    public static function initSession()
    {
        // 세션 변수 설정
        $auth_service = new self();
        $_SESSION['session_user_menu'] = $auth_service->getAdminMenu();
        $_SESSION['session_user_tag'] = $auth_service->getAdminTag();
        $_SESSION['session_user_tagid'] = $auth_service->getAdminTagId();
    }

    /**
     * @param Request $request
     * @return null|Response
     */
    public static function authorize($request)
    {
        if (!self::isValidLogin() || !self::isValidUser()) {
            $login_url = '/login';
            $request_uri = $request->getRequestUri();

            if (!empty($request_uri) && $request_uri != '/login' && $request_uri != '/logout') {
                $login_url .= '?return_url=' . urlencode($request_uri);
            }

            return RedirectResponse::create($login_url);
        }

        try {
            if (!self::authorizeRequest(LoginService::GetAdminID(), $request->getRequestUri())) {
                throw new \Exception("해당 권한이 없습니다.");
            }
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

    /**
     * @param string $user_id
     * @param string $request_url
     * @return bool
     */
    public static function authorizeRequest($user_id, $request_url)
    {
        $client = ThriftService::getHttpClient('AdminAuth');
        return $client->authorizeRequest($user_id, $request_url);
    }
}
