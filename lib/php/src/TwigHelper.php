<?php
declare(strict_types=1);

namespace Ridibooks\Cms;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

class TwigHelper
{
    /** @var Environment */
    private $twig;

    public function __construct(array $options)
    {
        $this->create($options);
        $this->addPHPFunction('strtotime');
    }

    private function create(array $options): void
    {
        $view_root_path = $options['view_root_path'] ?? [];
        $filesystem_loader = new FilesystemLoader($view_root_path);

        $twig_options = array_merge([
            'cache' => $options['cache_path'] ?? sys_get_temp_dir() . '/twig_cache_v1',
            'auto_reload' => true,
        ], $options);

        $this->twig = new Environment($filesystem_loader, $twig_options);
    }

    public function addPHPFunction(string $func): self
    {
        if (!function_exists($func)) {
            throw new \InvalidArgumentException("Not Exists function: {$func}");
        }

        $this->twig->addFilter(new TwigFilter($func, $func));

        return $this;
    }

    public function addGlobal(string $key, $value): self
    {
        $this->twig->addGlobal($key, $value);

        return $this;
    }

    public function render(string $view_file_path, $context): string
    {
        return $this->twig->render($view_file_path, $context);
    }
}
