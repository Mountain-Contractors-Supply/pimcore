<?php

declare(strict_types=1);

namespace App\Theme;

use McSupply\EcommerceBundle\Provider\OnlineStore\OnlineStoreProviderInterface;
use Pimcore\Http\Request\Resolver\PimcoreContextResolver;
use Sylius\Bundle\ThemeBundle\Context\SettableThemeContext;
use Sylius\Bundle\ThemeBundle\Context\ThemeContextInterface;
use Sylius\Bundle\ThemeBundle\Model\ThemeInterface;
use Sylius\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class OnlineStoreThemeContext implements ThemeContextInterface
{
    public function __construct(
        private ThemeRepositoryInterface     $themeRepository,
        private SettableThemeContext         $settableThemeContext,
        private OnlineStoreProviderInterface $onlineStoreProvider,
        private RequestStack                 $requestStack,
        private PimcoreContextResolver       $pimcoreContext,
    ) {}

    /**
     * @inheritDoc
     */
    #[\Override]
    public function getTheme(): ?ThemeInterface
    {
        $request = $this->requestStack->getMainRequest();

        if (!$request || null !== $this->settableThemeContext->getTheme()) {
            return $this->settableThemeContext->getTheme();
        }

        $isAjaxBrickRendering = $request->attributes->get('_route') === 'pimcore_admin_document_page_areabrick-render-index-editmode';

        if (!$isAjaxBrickRendering && $this->pimcoreContext->matchesPimcoreContext($request, PimcoreContextResolver::CONTEXT_ADMIN)) {
            return $this->settableThemeContext->getTheme();
        }

        try {
            $onlineStore = $this->onlineStoreProvider->getOnlineStore();
            $themeName = $onlineStore?->getTheme();

            return $themeName !== null ? $this->themeRepository->findOneByName($themeName) : null;
        } catch (\Exception) {
            return $this->settableThemeContext->getTheme();
        }
    }
}
