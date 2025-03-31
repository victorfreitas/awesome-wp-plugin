<?php

declare(strict_types=1);

namespace Awesome\Presentation\Controllers;

use Awesome\Application\Abstracts\Controller;
use Awesome\Infrastructure\Attributes\Action;
use Awesome\Infrastructure\Attributes\Filter;
use Awesome\Infrastructure\Facades\Plugin;
use Awesome\Presentation\Dto;
use Awesome\Presentation\Views;

use function Awesome\config;
use function Awesome\createView;

final readonly class Page extends Controller
{
    #[Filter(hook: 'plugin.action_links', config: true)]
    public function pluginLink(array $links): array
    {
        $link = new Dto\Link(
            url: config('plugin.page.url'),
            title: __('Settings', 'awesome')
        );
        $linkView = new Views\Link($link);

        return ['settings' => $linkView->render(), ...$links];
    }

    #[Action(hook: 'admin_menu')]
    public function addMainPage(): void
    {
        $page = new Dto\Page(
            title: config('plugin.title'),
            slug: config('plugin.slug'),
            description: __('Awesome settings page.', 'awesome')
        );
        $menuPage = new Dto\MenuPage(
            title: $page->title(),
            slug: $page->slug(),
            callback: createView(new Views\Page($page)),
            icon: 'dashicons-email-alt'
        );

        Plugin::addMenuPage($menuPage);
    }
}
