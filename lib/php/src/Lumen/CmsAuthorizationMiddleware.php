<?php
declare(strict_types=1);

namespace Ridibooks\Cms\Lumen;

use Ridibooks\Cms\MiniRouter;

class CmsAuthorizationMiddleware
{
    public function handle($request, \Closure $next)
    {
        $response = MiniRouter::shouldRedirectForLogin($request);
        if ($response !== null) {
            return $response;
        }

        return $next($request);
    }
}
