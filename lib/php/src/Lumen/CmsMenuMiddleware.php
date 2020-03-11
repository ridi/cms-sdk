<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Lumen;

use Illuminate\Support\Facades\Config;
use Ridibooks\Cms\Auth\AdminAuthService;

class CmsMenuMiddleware
{
    public function handle($request, \Closure $next)
    {
        $cms_menus = (new AdminAuthService())->getAdminMenu();

        $twig_global_config_key = 'twigbridge.twig.globals';

        $twig_globals = config($twig_global_config_key);
        $twig_globals = array_merge($twig_globals, ['menus' => $cms_menus]);
        config([$twig_global_config_key => $twig_globals]);

        return $next($request);
    }
}
