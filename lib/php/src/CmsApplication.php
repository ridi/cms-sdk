<?php
namespace Ridibooks\Cms;

use Psr\Cache\CacheItemPoolInterface;
use Ridibooks\Cms\Auth\AdminAuthService;
use Ridibooks\Cms\Auth\LoginService;
use Ridibooks\Cms\Thrift\ThriftService;
use Silex\Application;
use Silex\Application\TwigTrait;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CmsApplication extends Application
{
    use TwigTrait;

    const DEFAULT_CONFIG = [
        'debug' => false,
        'twig.path' => [],
        'twig.globals' => [],
        'thrift.rpc_url' => '',
        'thrift.rpc_secret' => '',
        'auth.cf_access_domain' => '',
        'auth.cf_audience_tag' => '',
        'auth.test_id' => '',
    ];

    public function __construct(array $values = [], CacheItemPoolInterface $cache)
    {
        parent::__construct(array_merge(
            self::DEFAULT_CONFIG, 
            array_filter($values)
        ));

        $this->setDefaultErrorHandler();
        self::initializeServices($this);
        $this->registerTwigServiceProvider($cache);
        $this->registerSessionServiceProvider();
    }

    static function initializeServices($cms_config)
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

    private function setDefaultErrorHandler()
    {
        $this->error(function (\Exception $e) {
            if (empty($this['debug'])) {
                return null;
            }

            if ($e instanceof HttpException) {
                return Response::create($e->getMessage(), $e->getStatusCode(), $e->getHeaders());
            }

            throw $e;
        });
    }

    private function registerTwigServiceProvider(CacheItemPoolInterface $cache)
    {
        $this->register(
            new TwigServiceProvider(), [
                'twig.path' => array_merge(
                    $this['twig.path'] ?? [],
                    [__DIR__ . '/../views/']
                ),
                'twig.options' => [
                    'cache' => sys_get_temp_dir() . '/twig_cache_v12',
                    'auto_reload' => true,
                    // TwigServiceProvider에서 기본으로 $this['debug']와 같게 설정되어 있는데 true 일경우
                    // if xxx is defined로 변수를 일일이 체크해줘야 하는 문제가 있어서 override 함
                    'strict_variables' => false
                ],
            ]
        );

        // see http://silex.sensiolabs.org/doc/providers/twig.html#customization
        $this->extend(
            'twig',
            function (\Twig_Environment $twig) use ($cache) {
                $under_dev = $this['debug'] ?? false;
                if ($under_dev) {
                    $cached_menu = $cache->getItem('menu');

                    if (!$cached_menu->isHit()) {
                        $menu = (new AdminAuthService())->getAdminMenu();
                        $cached_menu->set($menu);

                        $cached_menu->expiresAfter(24*3600);
                        $cache->save($cached_menu);
                    }
                    $menu = $cached_menu->get();
                } else {
                    $menu = (new AdminAuthService())->getAdminMenu();
                }

                $globals = $this['twig.globals'] ?? [];
                $globals = array_merge($globals, [
                    'menus' => $menu
                ]);
                foreach ($globals as $k => $v) {
                    $twig->addGlobal($k, $v);
                }
                $twig->addFilter(new \Twig_SimpleFilter('strtotime', 'strtotime'));
                return $twig;
            }
        );
    }

    private function registerSessionServiceProvider()
    {
        $this->register(
            new SessionServiceProvider(), [
                'session.storage.handler' => null
            ]
        );

        $this['flashes'] = $this->getFlashBag()->all();
    }

    public function addFlashInfo($message)
    {
        $this->getFlashBag()->add('info', $message);
    }

    public function addFlashSuccess($message)
    {
        $this->getFlashBag()->add('success', $message);
    }

    public function addFlashWarning($message)
    {
        $this->getFlashBag()->add('warning', $message);
    }

    public function addFlashError($message)
    {
        $this->getFlashBag()->add('danger', $message);
    }

    public function getFlashBag(): FlashBag
    {
        return $this['session']->getFlashBag();
    }
}
