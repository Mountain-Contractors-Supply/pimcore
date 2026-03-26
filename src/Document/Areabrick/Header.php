<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;

#[AsAreabrick(id: 'header')]
final class Header extends AbstractConfigurableAreabrick
{
    public function getName(): string
    {
        return 'Header';
    }

    public function getDescription(): string
    {
        return 'Header';
    }

    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Ui\Header::class;
    }
}
