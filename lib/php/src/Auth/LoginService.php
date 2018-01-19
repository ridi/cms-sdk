<?php

namespace Ridibooks\Cms\Auth;

use Ridibooks\Cms\Session\CouchbaseSessionHandler;

class LoginService
{
    const SESSION_TIMEOUT_SEC = 60 * 60 * 24 * 14; // 2주
    const ADMIN_ID_COOKIE_NAME = 'admin-id';

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

    /**
     * @param string $id
     * @deprecated
     */
    public static function setSessions($id)
    {
        //GetAdminID에 사용할 id를미리 set 한다.
        $_SESSION['session_admin_id'] = $id;
    }

    public static function resetSession()
    {
        $_SESSION['session_admin_id'] = null;

        @session_destroy();
    }

    public static function GetAdminID()
    {
        return $_COOKIE[self::ADMIN_ID_COOKIE_NAME];
    }

    public static function SetAdminID($admin_id)
    {
        setcookie(self::ADMIN_ID_COOKIE_NAME, $admin_id, self::SESSION_TIMEOUT_SEC,'', '', false, true);
    }

    public static function startSession()
    {
        session_set_cookie_params(self::SESSION_TIMEOUT_SEC, '/', $_SERVER['SERVER_NAME']);
        session_start();
    }

    public static function startCouchbaseSession($server_hosts)
    {
        session_set_save_handler(
            new CouchbaseSessionHandler(implode(',', $server_hosts), 'session', self::SESSION_TIMEOUT_SEC),
            true
        );

        self::startSession();
    }
}
