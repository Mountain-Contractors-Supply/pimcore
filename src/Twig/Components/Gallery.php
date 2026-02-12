<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Gallery')]
class Gallery
{
    public ?string $mainImage = null;
    public array $images = [];
}
