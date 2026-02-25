<?php

declare(strict_types=1);

namespace App\LinkGenerator;

use McSupply\EcommerceBundle\LinkGenerator\ProductLinkGenerator as BaseLinkGenerator;
use Pimcore\Model\DataObject\ClassDefinition\LinkGeneratorInterface;

final readonly class ProductLinkGenerator extends BaseLinkGenerator implements LinkGeneratorInterface
{
}
