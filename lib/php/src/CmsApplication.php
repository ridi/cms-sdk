<?php
namespace Ridibooks\Cms;

use Ridibooks\Cms\Auth\LoginService;
use Ridibooks\Cms\Thrift\ThriftService;

class CmsApplication
{
    public static function initializeServices($cms_config)
    {
        ThriftService::setEndPoint($cms_config['thrift.rpc_url'], $cms_config['thrift.rpc_secret']); 

        $test_id = '';
        if (!empty($cms_config['debug'])) {
            $test_id = $cms_config['auth.test_id'];
        }
        LoginService::initialize(
            $cms_config['auth.cf_access_domain'] ?? '',
            $cms_config['auth.cf_audience_tag'] ?? '',
            $test_id
        );
    }
}
