<?php

declare(strict_types=1);

namespace Awesome\Presentation\Views;

use Awesome\Domain\Interfaces\ViewInterface;
use Awesome\Domain\Interfaces\LinkInterface;

final readonly class Link implements ViewInterface
{
    public function __construct(private LinkInterface $link)
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        return sprintf(
            '<a href="%s">%s</a>',
            \esc_url($this->link->url()),
            \esc_html($this->link->title())
        );
    }
}
