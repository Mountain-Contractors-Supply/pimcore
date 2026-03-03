<?php

declare(strict_types=1);

namespace App\Provider\OnlineStore;

use Exception;
use McSupply\EcommerceBundle\Dto\OnlineStore\OnlineStoreInterface;
use McSupply\EcommerceBundle\Provider\OnlineStore\OnlineStoreProviderInterface;
use Pimcore\Http\Request\Resolver\DocumentResolver;
use Pimcore\Model\DataObject\OnlineStore;
use Pimcore\Model\Document;
use Pimcore\Model\Site;
use Pimcore\Tool\Frontend;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class OnlineStoreProvider implements OnlineStoreProviderInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private DocumentResolver $documentResolver,
    ) {
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function getOnlineStore(?int $onlineStoreId = null): ?OnlineStoreInterface
    {
        $onlineStoreId ??= (int)$this->requestStack->getMainRequest()?->get('store_id');

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

    /**
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function filterBranches(array $branches): array
    {
        $validBranches = [];
        $onlineStore = $this->getOnlineStore();

        if ($onlineStore instanceof OnlineStoreInterface) {
            $validBranchIds = $onlineStore->getValidBranchIds();

            foreach ($branches as $branch) {
                if (in_array($branch->getId(), $validBranchIds)) {
                    $validBranches[$branch->getId()] = $branch;
                }
            }
        }

        return $validBranches;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    #[\Override]
    public function filterShipMethods(array $shipMethods): array
    {
        $validShipMethods = [];
        $onlineStore = $this->getOnlineStore();

        if ($onlineStore instanceof OnlineStoreInterface) {
            $validShipMethodIds = $onlineStore->getValidShipMethodIds();

            foreach ($shipMethods as $shipMethod) {
                if (in_array($shipMethod->getCode(), $validShipMethodIds)) {
                    $validShipMethods[$shipMethod->getCode()] = $shipMethod;
                }
            }
        }

        return $validShipMethods;
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function filterPaymentMethods(array $paymentMethods): array
    {
        $validPaymentMethods = [];
        $onlineStore = $this->getOnlineStore();

        if ($onlineStore instanceof OnlineStoreInterface) {
            $validPaymentMethodIds = $onlineStore->getValidPaymentMethodIds();

            foreach ($paymentMethods as $paymentMethod) {
                if (in_array($paymentMethod->getCode(), $validPaymentMethodIds)) {
                    $validPaymentMethods[$paymentMethod->getCode()] = $paymentMethod;
                }
            }
        }

        return $validPaymentMethods;
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
