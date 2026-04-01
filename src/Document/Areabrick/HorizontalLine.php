<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'horizontal-line')]
final class HorizontalLine extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return 'Horizontal Line';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Horizontal line';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Ui\HorizontalLine::class;
    }
}
