<?php
namespace Ridibooks\Platform\Cms;

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

    public function __construct(array $values = [])
    {
        parent::__construct($values);

        $this->setDefaultErrorHandler();
        $this->registerTwigServiceProvider();
        $this->registerSessionServiceProvider();
    }

    private function setDefaultErrorHandler()
    {
        if (class_exists('Config')) {
            $this['debug'] = \Config::$UNDER_DEV;
        } else {
            $this['debug'] = $_ENV['debug'];
        }

        $this->error(function (\Exception $e) {
            if ($this['debug']) {
                return null;
            }

            if ($e instanceof HttpException) {
                return Response::create($e->getMessage(), $e->getStatusCode(), $e->getHeaders());
            }

            throw $e;
        });
    }

    private function registerTwigServiceProvider()
    {
        $this->register(
            new TwigServiceProvider(),
            [
                'twig.env.globals' => [],
                'twig.options' => [
                    'cache' => sys_get_temp_dir() . '/twig_cache_v12',
                    'auto_reload' => true,
                    // TwigServiceProvider에서 기본으로 $this['debug']와 같게 설정되어 있는데 true 일경우
                    // if xxx is defined로 변수를 일일이 체크해줘야 하는 문제가 있어서 override 함
                    'strict_variables' => false
                ]
            ]
        );

        // see http://silex.sensiolabs.org/doc/providers/twig.html#customization
        $this['twig'] = $this->extend(
            'twig',
            function (\Twig_Environment $twig) {
                $globals = array_merge($this->getTwigGlobalVariables(), $this['twig.env.globals']);
                foreach ($globals as $k => $v) {
                    $twig->addGlobal($k, $v);
                }

                foreach ($this->getTwigGlobalFilters() as $filter) {
                    $twig->addFilter($filter);
                }

                return $twig;
            }
        );

        $this['twig.loader.filesystem'] = $this->extend(
            'twig.loader.filesystem',
            function (\Twig_Loader_Filesystem $loader) {
                $loader->addPath(__DIR__ . '/../views/');

                return $loader;
            }
        );
    }

    private function getTwigGlobalVariables()
    {
        if (class_exists('Config')) {
            $globals = [
                'FRONT_URL' => 'http://' . \Config::$DOMAIN,
                'STATIC_URL' => '/admin/static',
                'BOWER_PATH' => '/static/bower_components',

                'MISC_URL' => \Config::$MISC_URL,
                'BANNER_URL' => \Config::$ACTIVE_URL . '/ridibooks_banner/',
                'ACTIVE_URL' => \Config::$ACTIVE_URL,
                'DM_IMAGE_URL' => \Config::$ACTIVE_URL . '/ridibooks_dm/',

                'PHP_SELF' => $_SERVER['PHP_SELF'],
                'REQUEST_URI' => $_SERVER['REQUEST_URI'],

                "HTTP_HOST_LINK" => \Config::$HTTP_HOST_LINK,
                "SSL_HOST_LINK" => \Config::$SSL_HOST_LINK,

                'base_url' => \Config::$DOMAIN
            ];
        } else {
            $globals = [
                'FRONT_URL' => 'http://' . $_ENV['DOMAIN'],
                'STATIC_URL' => '/admin/static',
                'BOWER_PATH' => '/static/bower_components',

                'MISC_URL' => $_ENV['MISC_URL'],
                'BANNER_URL' => $_ENV['ACTIVE_URL'] . '/ridibooks_banner/',
                'ACTIVE_URL' => $_ENV['ACTIVE_URL'],
                'DM_IMAGE_URL' => $_ENV['ACTIVE_URL'] . '/ridibooks_dm/',

                'PHP_SELF' => $_SERVER['PHP_SELF'],
                'REQUEST_URI' => $_SERVER['REQUEST_URI'],

                "HTTP_HOST_LINK" => $_ENV['HTTP_HOST_LINK'],
                "SSL_HOST_LINK" => $_ENV['SSL_HOST_LINK'],

                'base_url' => $_ENV['DOMAIN']
            ];
        }

        if (isset($_SESSION['session_user_menu'])) {
            $globals['session_user_menu'] = $_SESSION['session_user_menu'];
        }

        return $globals;
    }

    private function getTwigGlobalFilters()
    {
        return [
            new \Twig_SimpleFilter('strtotime', 'strtotime')
        ];
    }

    private function registerSessionServiceProvider()
    {
        $this->register(
            new SessionServiceProvider(),
            [
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
