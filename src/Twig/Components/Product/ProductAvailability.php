<?php

namespace App\Twig\Components\Product;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Product:ProductAvailability')]
class ProductAvailability
{
    public ?string $productId = null;
    public ?string $upc = null;
    public ?string $stock = 'In Stock';
    public ?string $price = null;
}
