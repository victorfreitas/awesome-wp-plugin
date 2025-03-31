<?php

declare(strict_types=1);

namespace Awesome\Application\Controllers;

use Awesome\Application\Abstracts\Controller;
use Awesome\Infrastructure\Attributes\Action;

final readonly class Email extends Controller
{
    #[Action(hook: 'wp_mail_succeeded')]
    public function handleMailSuccess(/*{ array data }*/): void
    {
    }

    #[Action(hook: 'wp_mail_failed')]
    public function handleMailError(/*{ \WP_Error error }*/): void
    {
    }
}
