<?php

declare(strict_types=1);

namespace Meals\Domain\Poll;

use Meals\Domain\Menu\Menu;

class Poll
{
    public function __construct(
        private int $id,
        private bool $isActive,
        private Menu $menu
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getMenu(): Menu
    {
        return $this->menu;
    }
}
