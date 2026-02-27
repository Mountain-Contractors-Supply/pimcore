<?php

declare(strict_types=1);

namespace App\LinkGenerator;

use McSupply\EcommerceBundle\LinkGenerator\ProductCategoryLinkGenerator as BaseLinkGenerator;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;

final readonly class ProductCategoryLinkGenerator extends BaseLinkGenerator implements LinkGeneratorInterface
{
}
