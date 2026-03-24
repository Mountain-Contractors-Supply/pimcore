<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'image')]
final class Image extends AbstractConfigurableAreabrick
{
    public function getName(): string
    {
        return 'Image';
    }

    public function getDescription(): string
    {
        return 'Image';
    }

    public function needsReload(): bool
    {
        return false;
    }

    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Ui\Image::class;
    }
}
