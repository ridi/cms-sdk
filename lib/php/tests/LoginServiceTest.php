<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Auth;

use PHPUnit\Framework\TestCase;

class LoginServiceTest extends TestCase
{
    public function testSetLoginContext()
    {
        LoginService::setLoginContext((object) ['user_id' => 'test']);
        $this->assertEquals('test', LoginService::GetAdminID());

        LoginService::setLoginContext(['user_id' => 'test2']);
        $this->assertEquals('test2', LoginService::GetAdminID());
    }
}
