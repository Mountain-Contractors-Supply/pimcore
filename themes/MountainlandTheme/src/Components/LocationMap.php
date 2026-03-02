<?php

declare(strict_types=1);

namespace MountainlandTheme\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\Map\Map;

#[AsTwigComponent('LocationMap')]
class LocationMap
{
    public ?Map $map = null;
    public ?string $style = null;
}
