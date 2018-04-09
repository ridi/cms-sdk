<?php

namespace Ridibooks\Cms\Auth;

class LoginService
{
    const ADMIN_ID_COOKIE_NAME = 'admin-id';
    const TOKEN_COOKIE_NAME = 'cms-token';

    private static $admin_id_for_test = null;

    public static function GetAdminID()
    {
        return self::$admin_id_for_test ?? ($_COOKIE[self::ADMIN_ID_COOKIE_NAME] ?? '');
    }

    public static function SetAdminID($admin_id)
    {
        self::$admin_id_for_test = $admin_id;
    }

    public static function getAccessToken()
    {
        return $_COOKIE[self::TOKEN_COOKIE_NAME] ?? '';
    }
}
