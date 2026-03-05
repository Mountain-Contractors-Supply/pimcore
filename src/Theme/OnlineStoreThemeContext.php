<?php

declare(strict_types=1);

namespace App\Theme;

use Exception;
use Pimcore\Http\Request\Resolver\PimcoreContextResolver;
use Pimcore\Model\DataObject\OnlineStore;
use Pimcore\Model\Document;
use Pimcore\Model\Site;
use Pimcore\Tool\Frontend;
use Sylius\Bundle\ThemeBundle\Context\SettableThemeContext;
use Sylius\Bundle\ThemeBundle\Context\ThemeContextInterface;
use Sylius\Bundle\ThemeBundle\Model\ThemeInterface;
use Sylius\Bundle\ThemeBundle\Repository\ThemeRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class OnlineStoreThemeContext implements ThemeContextInterface
{
    public function __construct(
        private ThemeRepositoryInterface $themeRepository,
        private SettableThemeContext     $settableThemeContext,
        private RequestStack             $requestStack,
        private PimcoreContextResolver   $pimcoreContext,
    ) {}

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
            $onlineStoreId = (int)$request->get('store_id');

            if ($onlineStoreId) {
                $onlineStore = OnlineStore::getById($onlineStoreId);
            } else {
                try {
                    $site = Site::getCurrentSite();
                } catch (Exception) {
                    $site = $this->resolveSite($request);
                }

                $onlineStore = $site !== null ? OnlineStore::getBySite($site->getId(), 1) : null;
            }

            /** @var OnlineStore|null $onlineStore */
            $themeName = $onlineStore?->getTheme();

            return $themeName !== null ? $this->themeRepository->findOneByName($themeName) : null;
        } catch (\Exception) {
            return $this->settableThemeContext->getTheme();
        }
    }

    private function resolveSite(Request $request): ?Site
    {
        $isAjaxBrickRendering = $request->attributes->get('_route') === 'pimcore_admin_document_page_areabrick-render-index-editmode';
        $document = null;

        if ($isAjaxBrickRendering) {
            $documentId = $request->request->get('documentId');
            if ($documentId) {
                $document = Document::getById((int) $documentId);
            }
        } else {
            $document = $request->attributes->get('_document');

            if (!$document) {
                try {
                    $document = Document::getByPath($request->getPathInfo());
                } catch (Exception) {
                    $document = null;
                }
            }
        }

        return $document !== null ? Frontend::getSiteForDocument($document) : null;
    }
}
