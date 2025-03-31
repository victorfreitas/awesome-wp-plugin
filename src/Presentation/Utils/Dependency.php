<?php

declare(strict_types=1);

namespace Awesome\Presentation\Utils;

use Awesome\Infrastructure\Facades\Plugin;

use function Awesome\config;

final class Dependency
{
    public function addStyle(
        string $handle,
        string $src,
        array $deps = [],
        ?string $ver = null,
        string $media = 'all'
    ): void {

        $filename = sprintf('resources/css/%s.css', $src);

        $this->enqueueStyle(
            $this->handleName($handle),
            Plugin::pluginUrl($filename),
            $deps,
            $ver ?? Plugin::fileVersion($filename),
            $media
        );
    }

    public function addScript(
        string $handle,
        string $src,
        array $deps = [],
        ?string $ver = null,
        array $args = []
    ): void {

        $filename = sprintf('resources/js/%s.js', $src);
        $args['in_footer'] ??= true;

        $this->enqueueScript(
            $this->handleName($handle),
            Plugin::pluginUrl($filename),
            $deps,
            $ver ?? Plugin::fileVersion($filename),
            $args
        );
    }

    public function enqueueScript(
        string $handle,
        string $src,
        array $deps = [],
        string|int $ver = null,
        array $args = []
    ): void {

        \wp_enqueue_script($handle, $src, $deps, $ver, $args);
    }

    public function enqueueStyle(
        string $handle,
        string $src,
        array $deps = [],
        string|int $ver = null,
        string $media = 'all'
    ): void {

        \wp_enqueue_style($handle, $src, $deps, $ver, $media);
    }

    public function handleName(string $name): string
    {
        return config('plugin.slug') . '-' . $name;
    }
}
