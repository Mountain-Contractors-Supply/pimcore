<?php

declare(strict_types=1);

namespace App\OptionProvider;

use Pimcore\Model\DataObject\ClassDefinition\Data;
use Sylius\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;

final readonly class ThemeSelect extends AbstractOptionProvider
{
    public function __construct(
        private ThemeRepositoryInterface $themeRepository,
    )
    {
    }

    /**
     * @param array<string, mixed> $context
     * @param Data $fieldDefinition
     * @return array<string, mixed>[]
    */
    public function getOptions(array $context, Data $fieldDefinition): array
    {
        $options = [];

        foreach ($this->themeRepository->findAll() as $theme) {
            $options[] = [
                'key' => $theme->getDescription(),
                'value' => $theme->getName(),
            ];
        }

        return $options;
    }
}
