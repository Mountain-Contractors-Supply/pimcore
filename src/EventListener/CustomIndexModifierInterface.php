<?php

declare(strict_types=1);

namespace App\EventListener;

interface CustomIndexModifierInterface
{
    /**
     * @param array<string, mixed> $customFields
     * @return array<string, mixed>
     */
    public function modifyCustomFields(array $customFields): array;

    /**
     * @param array<string, mixed> $customMapping
     * @return array<string, mixed>
     */
    public static function modifyCustomMapping(array $customMapping): array;
}
