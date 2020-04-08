<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Lumen;

use Illuminate\View\FileViewFinder;
use Laravel\Lumen\Application;
use Laravel\Lumen\Bootstrap\LoadEnvironmentVariables;
use Ridibooks\Cms\CmsApplication;
use Ridibooks\Cms\Constants\CmsConfigConst;

class LumenApplication
{
    /** @var Application */
    public $app;

    /** @var array */
    private $cms_config;

    public function __construct(array $cms_config)
    {
        $this->cms_config = array_merge(CmsConfigConst::DEFAULT_CONFIG, $cms_config);
        CmsApplication::initializeServices($this->cms_config);

        $this->lumenBootstrap();
        $this->setupView();
        $this->enableMiddleware();
    }

    private function lumenBootstrap(): void
    {
        (new LoadEnvironmentVariables($this->cms_config[CmsConfigConst::BASE_PATH]))->bootstrap();

        $error_types = error_reporting();

        $_ENV['APP_DEBUG'] = $this->cms_config[CmsConfigConst::DEBUG]; // override debug mode
        $this->app = new Application($this->cms_config[CmsConfigConst::BASE_PATH]);

        error_reporting($error_types); // restore error_reporting {@see Application::registerErrorHandling}

        $this->app->withFacades();
    }

    private function setupView(): void
    {
        // not use lumen view folder
        $view_paths = array_filter(array_merge($this->cms_config[CmsConfigConst::TWIG_PATH], [__DIR__ . '/../../views/']));
        $this->app->extend('view.finder', function ($finder, $app) use ($view_paths) {
            /** @var FileViewFinder $finder */
            return $finder->setPaths($view_paths);
        });
        config(['view.paths' => $view_paths]);

        TwigConfigure::buildConfigure($this->app, $this->cms_config);
    }

    public function route(\Closure $closure): void
    {
        $this->app->router->group(['namespace' => $this->cms_config[CmsConfigConst::BASE_CONTROLLER_NAMESPACE]], $closure);
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

        $functions = config($config_key);
        $functions[$function_name] = $closure;
        config([$config_key => $functions]);
    }

    public function addTwigFilter(string $function_name, \Closure $closure): void
    {
        $config_key = 'twigbridge.extensions.filters';

        $filters = config($config_key);
        $filters[$function_name] = $closure;
        config([$config_key => $filters]);
    }

    private function enableMiddleware(): void
    {
        $this->app->middleware([CmsAuthorizationMiddleware::class]);
        $this->app->middleware([CmsMenuMiddleware::class]);
    }

    public function run(): void
    {
        $this->app->register('TwigBridge\ServiceProvider');

        $this->app->run();
    }
}
