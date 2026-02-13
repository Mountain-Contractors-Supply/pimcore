<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Gallery')]
class Gallery
{
    public ?string $mainImage = null;

    /** @var string[] */
    public array $images = [];
}
