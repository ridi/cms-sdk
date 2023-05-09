<?php

namespace Ridibooks\Cms\Auth;

use Ridibooks\Cms\Thrift\Errors\NoTokenException;

class LoginService
{
    const X_AUTH_REQUEST_EMAIL = 'x-auth-request-email';
    const X_AUTH_REQUEST_ACCESS_TOKEN = 'x-auth-request-access-token';

    private static string $admin_id = '';

    public static function initialize(?string $test_id)
    {
        if (empty(self::$admin_id)) {
            self::$admin_id = $test_id;
        }
    }

    public static function GetAdminID()
    {
        return self::$admin_id;
    }

    public static function SetAdminIDForTest($admin_id)
    {
        self::$admin_id = $admin_id;
    }

    public static function getEmail()
    {
        $headers = getallheaders();
        return $headers[self::X_AUTH_REQUEST_EMAIL] ?? '';
    }

    public static function getAccessToken()
    {
        $headers = getallheaders();
        return $headers[self::X_AUTH_REQUEST_ACCESS_TOKEN] ?? '';
    }

    public static function authenticate(): string
    {
        if (!empty(self::$admin_id)) {
            return self::$admin_id;
        }

        $email = self::getEmail();
        $token = self::getAccessToken();
        if (empty($token) || empty($email)) {
            throw new NoTokenException('No token in request header');
        }

        self::$admin_id = explode('@', $email);

        return self::$admin_id;
    }
}
