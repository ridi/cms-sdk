<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Auth;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class LoginServiceTest extends TestCase
{
    public function testSetLoginContext()
    {
        LoginService::setLoginContext((object) ['user_id' => 'test']);
        $this->assertEquals('test', LoginService::GetAdminID());

        LoginService::setLoginContext(['user_id' => 'test2']);
        $this->assertEquals('test2', LoginService::GetAdminID());
    }

    public function testRedirectToLogin()
    {
        $req = Request::create('/test');

        /**
         * @var RedirectResponse
         */
        $res = LoginService::createRedirectForLogin($req);
        $this->assertInstanceOf(RedirectResponse::class, $res);
        $this->assertEquals("/login?return_url=" . urlencode('/test'), $res->getTargetUrl());
    }

    public function testRedirectToTokenRefresh()
    {
        // Set token expired state.
        LoginService::setLoginContext(['error' => 'Authentication_ExpiredToken']);
        $req = Request::create('/test');

        /**
         * @var RedirectResponse
         */
        $res = LoginService::createRedirectForLogin($req);
        $this->assertInstanceOf(RedirectResponse::class, $res);
        $this->assertStringEndsWith("/token-refresh?return_url=" . urlencode('/test'), $res->getTargetUrl());
    }
}
