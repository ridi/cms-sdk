<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Constants;

class CmsConfigConst
{
    public const DEBUG = 'debug';
    public const BASE_PATH = 'base.path';
    public const BASE_CONTROLLER_NAMESPACE = 'base.controller_namespace';
    public const TWIG_PATH = 'twig.path';
    public const TWIG_GLOBALS = 'twig.globals';
    public const THRIFT_RPC_URL = 'thrift.rpc_url';
    public const THRIFT_RPC_SECRET = 'thrift.rpc_secret';
    public const AUTH_CF_ACCESS_DOMAIN = 'auth.cf_access_domain';
    public const AUTH_CF_AUDIENCE_TAG = 'auth.cf_audience_tag';
    public const AUTH_TEST_ID = 'auth.test_id';

    public const DEFAULT_CONFIG = [
        self::DEBUG => false,
        self::BASE_PATH => '',
        self::BASE_CONTROLLER_NAMESPACE => '',
        self::TWIG_PATH => [],
        self::TWIG_GLOBALS => [],
        self::THRIFT_RPC_URL => '',
        self::THRIFT_RPC_SECRET => '',
        self::AUTH_CF_ACCESS_DOMAIN => '',
        self::AUTH_CF_AUDIENCE_TAG => '',
        self::AUTH_TEST_ID => '',
    ];
}
