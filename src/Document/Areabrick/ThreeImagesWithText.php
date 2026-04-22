<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'three-images-with-text')]
final class ThreeImagesWithText extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return 'Three images with text';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Three images in columns with text below';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Ui\ThreeImagesWithText::class;
    }
}