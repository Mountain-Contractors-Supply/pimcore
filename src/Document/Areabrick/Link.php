<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'link')]
final class Link extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return 'Link';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Link';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Navigation\Link::class;
    }
}
