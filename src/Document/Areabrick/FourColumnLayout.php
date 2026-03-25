<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'four-column-layout')]
final class FourColumnLayout extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return '4-Column Layout';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Generic empty 4-column layout';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Layout\TwoColumn::class;
    }
}
