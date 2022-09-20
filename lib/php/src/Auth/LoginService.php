<?php

namespace Ridibooks\Cms\Auth;

use Ridibooks\Cms\Thrift\Errors\NoTokenException;

class LoginService
{
    private static $admin_id = '';

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

    public static function getAccessToken()
    {
        $headers = getallheaders();
        $token = $headers['X-Auth-Request-Access-Token'];
        return $token ?? '';
    }

    public static function getEmail()
    {
        $headers = getallheaders();
        $email = $headers['X-Auth-Request-Email'];
        return $email ?? '';
    }

    /**
     * @throws NoTokenException
     */
    public static function authenticate(): string
    {
        if (!empty(self::$admin_id)) {
            return self::$admin_id;
        }

        $token = self::getAccessToken();
        $email = self::getEmail();
        if (empty($token) or empty($email)) {
            throw new NoTokenException('No token or email exists');
        }

        self::$admin_id = explode('@', $email)[0];
        return self::$admin_id;
    }
}
