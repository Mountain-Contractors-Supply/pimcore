<?php

declare(strict_types=1);

namespace App\EventListener;

interface PreAddUpdateAwareInterface
{
    /**
     * @return void
     */
    public function onPreAdd(): void;

    /**
     * @return void
     */
    public function onPreUpdate(): void;
}
