<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\AbstractTemplateAreabrick;

class Wysiwyg extends AbstractTemplateAreabrick
{
    public function getName(): string
    {
        return 'WYSIWYG';
    }

    public function getDescription(): string
    {
        return 'Generic WYSIWYG component';
    }

    public function needsReload(): bool
    {
        return false;
    }
}
