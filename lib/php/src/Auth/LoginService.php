<?php

namespace Ridibooks\Cms\Auth;

class LoginService
{
    const ADMIN_ID_COOKIE_NAME = 'admin-id';
    const TOKEN_COOKIE_NAME = 'cms-token';

    public static function GetAdminID()
    {
        return $_COOKIE[self::ADMIN_ID_COOKIE_NAME] ?? null;
    }

    public static function getAccessToken()
    {
        return $_COOKIE[self::TOKEN_COOKIE_NAME] ?? null;
    }
}
