<?php

namespace Ridibooks\Cms\Auth;

use Ridibooks\Cms\Thrift\Errors\NoTokenException;

class LoginService
{
    const TOKEN_COOKIE_NAME = 'CF_Authorization';

    private static $admin_id = '';
    private static $cf_access_domain = '';
    private static $cf_audience_tag = '';

    public static function initialize(string $cf_access_domain, string $cf_audience_tag)
    {
        self::$cf_access_domain = $cf_access_domain;
        self::$cf_audience_tag = $cf_audience_tag;
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
        return $_COOKIE[self::TOKEN_COOKIE_NAME] ?? '';
    }

    public static function authenticate(): string
    {
        $token = self::getAccessToken();
        if (empty($token)) {
            throw new NoTokenException('No cloudflare token exists');
        }

        $validator = new CFJwtValidator();
        $key = $validator->getPublicKey(self::$cf_access_domain);
        $decoded = $validator->decodeJwt($token, $key, self::$cf_audience_tag);
        self::$admin_id = explode('@', $decoded->email)[0];

        return self::$admin_id;
    }
}
