<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'grid')]
final class Grid extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return 'Grid';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Configurable column grid';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Layout\Grid::class;
    }
}
