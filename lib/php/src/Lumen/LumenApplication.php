<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Lumen;

use Illuminate\Support\Facades\Config;
use Laravel\Lumen\Application;
use Laravel\Lumen\Bootstrap\LoadEnvironmentVariables;
use Ridibooks\Cms\CmsApplication;
use Ridibooks\Cms\MiniRouter;
use Symfony\Component\HttpFoundation\Request;

class LumenApplication
{
    const DEFAULT_CONFIG = [
        'debug' => false,
        'base.path' => '',
        'base.controller_namespace' => '',
        'twig.path' => [],
        'twig.globals' => [],
        'thrift.rpc_url' => '',
        'thrift.rpc_secret' => '',
        'auth.cf_access_domain' => '',
        'auth.cf_audience_tag' => '',
        'auth.test_id' => '',
    ];

    /** @var Application */
    public $app;

    /** @var array */
    private $cms_config;

    public function __construct(array $cms_config)
    {
        $this->cms_config = array_merge(self::DEFAULT_CONFIG, $cms_config);
        CmsApplication::initializeServices($this->cms_config);

        $request = Request::createFromGlobals();
        MiniRouter::shouldRedirectForLogin($request);

        $this->lumenBootstrap();
        $this->setupView();
    }

    private function lumenBootstrap(): void
    {
        (new LoadEnvironmentVariables($this->cms_config['base.path']))->bootstrap();
        $this->app = new Application($this->cms_config['base.path']);

        $this->app->withFacades();
    }

    private function setupView(): void
    {
        $view_paths = array_filter([$this->cms_config['twig.path'], __DIR__ . '/../../views/']);
        Config::set('view.paths', $view_paths); // not use lumen view folder

        TwigConfigure::buildConfigure($this->app, $this->cms_config);
        $this->app->middleware([CmsMenuMiddleware::class]);
    }

    public function route(\Closure $closure): void
    {
        $this->app->router->group(['namespace' => $this->cms_config['base.controller_namespace']], $closure);
    }

    public function registerErrorHandler(string $class_name): void
    {
        $this->app->singleton(\Illuminate\Contracts\Debug\ExceptionHandler::class, $class_name);
    }

    public function registerConsoleKernel(string $class_name): void
    {
        $this->app->singleton(\Illuminate\Contracts\Console\Kernel::class, $class_name);
    }

    public function addTwigFunction(string $function_name, \Closure $closure): void
    {
        $config_key = 'twigbridge.extensions.functions';

        $functions = Config::get($config_key);
        $functions[$function_name] = $closure;
        Config::set($config_key, $functions);
    }

    public function addTwigFilter(string $function_name, \Closure $closure): void
    {
        $config_key = 'twigbridge.extensions.filters';

        $filters = Config::get($config_key);
        $filters[$function_name] = $closure;
        Config::set($config_key, $filters);
    }

    public function run(): void
    {
        $this->app->register('TwigBridge\ServiceProvider');

        $this->app->run();
    }
}
