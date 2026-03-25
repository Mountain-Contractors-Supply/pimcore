<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;
use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;

#[AsAreabrick(id: 'grid')]
final class Grid extends AbstractTemplateAreabrick
{
    public function getName(): string
    {
        return 'Grid';
    }

    public function getDescription(): string
    {
        return 'Grid';
    }

    public function needsReload(): bool
    {
        return false;
    }
}
