<?php

namespace Ridibooks\Cms\Auth;

class PasswordService
{
    public static function needsRehash($hashed_password)
    {
        return password_needs_rehash($hashed_password, PASSWORD_DEFAULT);
    }

    public static function getPasswordAsHashed($plain_password)
    {
        return password_hash($plain_password, PASSWORD_DEFAULT);
    }

    public static function isPasswordMatchToHashed($plain_password, $hashed_password)
    {
        return password_verify($plain_password, $hashed_password);
    }
}
