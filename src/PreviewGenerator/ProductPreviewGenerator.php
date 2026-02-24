<?php

declare(strict_types=1);

namespace App\PreviewGenerator;

use App\LinkGenerator\ProductLinkGenerator;

final readonly class ProductPreviewGenerator extends AbstractStoreAwarePreviewGenerator
{
    public function __construct(ProductLinkGenerator $linkGenerator)
    {
        parent::__construct($linkGenerator);
    }
}
