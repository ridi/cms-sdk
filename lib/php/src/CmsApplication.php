<?php
namespace Ridibooks\Cms;

use Ridibooks\Cms\Auth\LoginService;
use Ridibooks\Cms\Constants\CmsConfigConst;
use Ridibooks\Cms\Thrift\ThriftService;

class CmsApplication
{
    public static function initializeServices($cms_config)
    {
        ThriftService::setEndPoint($cms_config[CmsConfigConst::THRIFT_RPC_URL], $cms_config[CmsConfigConst::THRIFT_RPC_SECRET]);

        $test_id = '';
        if (!empty($cms_config[CmsConfigConst::DEBUG])) {
            $test_id = $cms_config[CmsConfigConst::AUTH_TEST_ID];
        }
        LoginService::initialize(
            $cms_config[CmsConfigConst::AUTH_CF_ACCESS_DOMAIN] ?? '',
            $cms_config[CmsConfigConst::AUTH_CF_AUDIENCE_TAG] ?? '',
            $test_id
        );
    }
}
