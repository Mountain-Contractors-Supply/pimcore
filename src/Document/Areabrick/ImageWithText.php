<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'image-with-text')]
final class ImageWithText extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return 'Image with text';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Image with text';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Ui\ImageWithText::class;
    }
}
