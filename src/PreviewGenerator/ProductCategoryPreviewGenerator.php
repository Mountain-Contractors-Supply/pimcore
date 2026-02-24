<?php

declare(strict_types=1);

namespace App\PreviewGenerator;

use App\LinkGenerator\ProductCategoryLinkGenerator;

final readonly class ProductCategoryPreviewGenerator extends AbstractStoreAwarePreviewGenerator
{
    public function __construct(ProductCategoryLinkGenerator $linkGenerator)
    {
        parent::__construct($linkGenerator);
    }
}
