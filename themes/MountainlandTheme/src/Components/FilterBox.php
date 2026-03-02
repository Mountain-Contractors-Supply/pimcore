<?php

declare(strict_types=1);

namespace MountainlandTheme\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('FilterBox')]
class FilterBox
{
    public string $searchTermValue = '';
    public string $draftSearchTerm = '';

    /**
     * @var string[]
     */
    public array $selectedValues = [];

    /**
     * @var string[]
     */
    public array $draftSelectedProductTypes = [];

    /**
     * @var array<int, mixed>
     */
    public array $productTypes = [];

    public string $searchTermModel = 'draftSearchTerm';
    public string $selectedValuesModel = 'draftSelectedProductTypes';

    public string $searchAction = 'applyFilters';
    public string $resetAction = 'resetFilters';

    public function mount(): void
    {
        if ($this->searchTermValue === '' && $this->draftSearchTerm !== '') {
            $this->searchTermValue = $this->draftSearchTerm;
        }

        if ($this->selectedValues === [] && $this->draftSelectedProductTypes !== []) {
            $this->selectedValues = $this->draftSelectedProductTypes;
        }
    }

    public function isSelected(string $value): bool
    {
        return in_array($value, $this->selectedValues, true);
    }
}
