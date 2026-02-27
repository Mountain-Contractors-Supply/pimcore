<?php

declare(strict_types=1);

namespace App\Provider;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Resolver\DefaultDataResolver;
use Pimcore\Http\Request\Resolver\DocumentResolver;
use Pimcore\Model\DataObject\OnlineStore;
use Pimcore\Model\Document;
use Pimcore\Model\Site;
use Pimcore\Tool\Frontend;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @implements DataProviderInterface<OnlineStoreInterface>
 */
#[DataProvider(OnlineStoreInterface::class, DefaultDataResolver::class, 10)]
final readonly class PimcoreOnlineStoreProvider implements DataProviderInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private DocumentResolver $documentResolver,
    ) {}

    #[\Override]
    public function supports(string $className, mixed $data = null): bool
    {
        return true;
    }

    #[\Override]
    public function get(string $className, mixed $data = null): ?OnlineStoreInterface
    {
        $onlineStoreId = (int)$this->requestStack->getMainRequest()?->get('store_id');

        if ($onlineStoreId) {
            return OnlineStore::getById($onlineStoreId);
        }

        try {
            $site = Site::getCurrentSite();
        } catch (Exception) {
            $site = $this->resolveSite();
        }

        /** @var OnlineStoreInterface|null $onlineStore */
        $onlineStore = $site !== null ? OnlineStore::getBySite($site->getId(), 1) : null;

        return $onlineStore;
    }

    #[\Override]
    public function save(mixed $dto, mixed $data = null): void
    {
        // TODO: Implement save() method.
    }

    /**
     * @return Site|null
     */
    private function resolveSite(): ?Site
    {
        $request = $this->requestStack->getMainRequest();

        if ($request === null) {
            return null;
        }

        $isAjaxBrickRendering = $request->attributes->get('_route') === 'pimcore_admin_document_page_areabrick-render-index-editmode';
        $document = null;

        if ($isAjaxBrickRendering) {
            $documentId = $request->request->get('documentId');

            if ($documentId) {
                $document = Document::getById((int) $documentId);
            }
        } else {
            $document = $this->documentResolver->getDocument($request);
        }

        return $document !== null ? Frontend::getSiteForDocument($document) : null;
    }
}
