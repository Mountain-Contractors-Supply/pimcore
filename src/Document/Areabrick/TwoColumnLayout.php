<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'two-column-layout')]
final class TwoColumnLayout extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return '2-Column Layout';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Generic empty 2-column layout';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Layout\TwoColumn::class;
    }
}
