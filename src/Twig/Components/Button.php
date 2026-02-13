<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent]
class Button
{
    public string $variant = 'primary';
    public string $tag = 'button';
    public string $size = 'md';

    #[ExposeInTemplate]
    public function getButtonClasses(): string
    {
        return $this->getSizeClasses() . ' ' . $this->getVariantClasses() . ' font-medium rounded-lg focus:outline-none transition-colors';
    }

    public function getVariantClasses(): string
    {
        return match ($this->variant) {
            'primary' => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300',
            'success' => 'text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:ring-green-300',
            'danger' => 'text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300',
            'secondary' => 'text-gray-900 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300',
            'link' => 'text-blue-600 hover:text-blue-800 hover:underline',
            default => 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300',
        };
    }

    public function getSizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'px-3 py-1.5 text-sm',
            'md' => 'px-4 py-2 text-sm',
            'lg' => 'px-5 py-3 text-base',
            default => 'px-4 py-2 text-sm',
        };
    }
}
