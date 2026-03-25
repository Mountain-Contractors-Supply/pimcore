<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'three-column-layout')]
final class ThreeColumnLayout extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return '3-Column Layout';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Generic empty 3-column layout';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Layout\ThreeColumn::class;
    }
}
