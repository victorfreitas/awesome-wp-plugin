<?php

declare(strict_types=1);

namespace Awesome\Presentation\Views;

use Awesome\Infrastructure\Attributes\Action;
use Awesome\Infrastructure\Facades\App;
use Awesome\Infrastructure\Loggers\Level;
use Awesome\Presentation\Abstracts;

/**
 * Class Notice
 *
 * @package Awesome\Presentation\Views
 */
final class Notice extends Abstracts\Notice
{
    #[Action(hook: 'admin_notices')]
    public function display(): void
    {
        $classes = ['notice', 'notice-' . $this->notice->type()];

        if ($this->notice->isDismissible()) {
            $classes[] = 'is-dismissible';
        }

        $this->addLog();

        echo \sprintf(
            '<div class="%s">
				<p>
					<strong>%s</strong>
					%s
				</p>
			</div>',
            \esc_attr(\implode(' ', $classes)),
            \esc_html__('Awesome: ', 'awesome'),
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
            $this->notice->message()
        );
    }

    private function addLog(): void
    {
        $level = match ($this->notice->type()) {
            'error' => Level::Error,
            'warning' => Level::Warning,
            default => Level::Notice,
        };

        App::logger()->log(
            $level->value,
            $this->notice->message(),
            ['source' => get_class($this->notice)]
        );
    }
}
