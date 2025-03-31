<?php

declare(strict_types=1);

namespace Awesome\Presentation\Dto;

use Awesome\Domain\Interfaces\MenuPageInterface;

final readonly class MenuPage implements MenuPageInterface
{
    public function __construct(
        private string $title,
        private string $slug,
        private \Closure $callback,
        private string $capability = 'manage_options',
        private string $icon = '',
        private ?int $position = null,
        private ?string $menuTitle = null
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function capability(): string
    {
        return $this->capability;
    }

    public function icon(): string
    {
        return $this->icon;
    }

    public function position(): ?int
    {
        return $this->position;
    }

    public function menuTitle(): string
    {
        return $this->menuTitle ?? $this->title();
    }

    public function callback(): \Closure
    {
        return $this->callback;
    }
}
