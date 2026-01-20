<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\Bundle\TwigBundle\DependencyInjection\Configurator\EnvironmentConfigurator;
use Symfony\UX\TwigComponent\Twig\TwigEnvironmentConfigurator as UxEnvironmentConfigurator;
use Twig\Environment;

readonly class CompatibleConfigurator
{
    public function __construct(
        private EnvironmentConfigurator|UxEnvironmentConfigurator $decorated,
    ) {
    }

    /**
     * @param Environment $environment
     * @return void
     */
    public function configure(Environment $environment): void
    {
        $this->decorated->configure($environment);
    }
}
