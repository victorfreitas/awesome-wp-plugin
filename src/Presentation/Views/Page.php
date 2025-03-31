<?php

declare(strict_types=1);

namespace Awesome\Presentation\Views;

use Awesome\Domain\Interfaces\ViewInterface;
use Awesome\Domain\Interfaces\PageInterface;

final readonly class Page implements ViewInterface
{
    public function __construct(private PageInterface $page)
    {
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        return sprintf(
            '<div class="wrap">
				<h1 class="wp-heading-inline">%s</h1>
				<p>%s</p>
			</div>',
            \esc_html($this->page->title()),
            \esc_html($this->page->description())
        );
    }
}
