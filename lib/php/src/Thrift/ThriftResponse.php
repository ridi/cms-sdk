<?php

namespace Ridibooks\Cms\Thrift;

use Ridibooks\Cms\Service\AdminMenuService;
use Ridibooks\Cms\Service\AdminTagService;
use Ridibooks\Cms\Service\AdminUserService;
use Ridibooks\Cms\Service\AdminAuthService;
use Ridibooks\Cms\Thrift\AdminMenu\AdminMenuServiceProcessor;
use Ridibooks\Cms\Thrift\AdminTag\AdminTagServiceProcessor;
use Ridibooks\Cms\Thrift\AdminUser\AdminUserServiceProcessor;
use Ridibooks\Cms\Thrift\AdminAuth\AdminAuthServiceProcessor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Thrift\Protocol\TJSONProtocol;
use Thrift\TMultiplexedProcessor;
use Thrift\Transport\TMemoryBuffer;

class ThriftResponse
{
    public static function create(Request $request)
    {
        $processor = new TMultiplexedProcessor();
        $menu_processor = new AdminMenuServiceProcessor(new AdminMenuService());
        $processor->registerProcessor('AdminMenu', $menu_processor);
        $user_processor = new AdminUserServiceProcessor(new AdminUserService());
        $processor->registerProcessor('AdminUser', $user_processor);
        $tag_processor = new AdminTagServiceProcessor(new AdminTagService());
        $processor->registerProcessor('AdminTag', $tag_processor);
        $auth_processor = new AdminAuthServiceProcessor(new AdminAuthService());
        $processor->registerProcessor('AdminAuth', $auth_processor);

        $readTransport = new TMemoryBuffer($request->getContent(false));
        $writeTransport = new TMemoryBuffer();
        $readProtocol = new TJSONProtocol($readTransport);
        $writeProtocol = new TJSONProtocol($writeTransport);

        $readTransport->open();
        $writeTransport->open();
        $processor->process($readProtocol, $writeProtocol);
        $readTransport->close();
        $writeTransport->close();

        $content = $writeTransport->getBuffer();
        return Response::create($content, 200, [
            'Content-Type' => 'application/x-thrift'
        ]);
    }
}
