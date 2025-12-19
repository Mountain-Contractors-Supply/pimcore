<?php

declare(strict_types=1);

namespace App\EventListener;

interface PostAddUpdateAwareInterface
{
    public function onPostAdd(): void;

    public function onPostUpdate(): void;
}
