<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'row-images-with-text')]
final class RowImagesWithText extends AbstractConfigurableAreabrick
{
    #[\Override]
    public function getName(): string
    {
        return 'Row of images with text';
    }

    #[\Override]
    public function getDescription(): string
    {
        return 'Row of images in columns with text below';
    }

    #[\Override]
    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Ui\RowImagesWithText::class;
    }
}
