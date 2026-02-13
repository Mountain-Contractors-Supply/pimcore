<?php

namespace App\Twig\Components\Product;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Product:ProductActions')]
class ProductActions
{
    public int $quantity = 1;
    public string $addToCartText = 'Add to Cart';
}
