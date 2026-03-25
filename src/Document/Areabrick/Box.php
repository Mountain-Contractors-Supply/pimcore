<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'box')]
final class Box extends AbstractConfigurableAreabrick
{
    public function getName(): string
    {
        return 'Box';
    }

    public function getDescription(): string
    {
        return 'Box';
    }

    public function needsReload(): bool
    {
        return false;
    }

    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Layout\Box::class;
    }
}
