<?php

declare(strict_types=1);

namespace App\Provider\Navigation;

use Exception;
use McSupply\EcommerceBundle\Attribute\DataProvider;
use McSupply\EcommerceBundle\Dto\Navigation\Link;
use McSupply\EcommerceBundle\Provider\DataProviderInterface;
use McSupply\EcommerceBundle\Provider\ReadOperationInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareInterface;
use McSupply\EcommerceBundle\Provider\DataResolverAwareTrait;
use Pimcore\Model\DataObject\OnlineStore;
use Pimcore\Model\Document;
use Pimcore\Model\Site;

/**
 * @implements DataProviderInterface<Link>
 * @implements ReadOperationInterface<Link>
 */
#[DataProvider(Link::class, 20)]
final class PimcoreMenuProvider implements DataProviderInterface, DataResolverAwareInterface, ReadOperationInterface
{
    use DataResolverAwareTrait;

    #[\Override]
    public function supports(string $className, array $data = []): bool
    {
        return true;
    }

    /**
     * @throws Exception
     */
    #[\Override]
    public function get(string $className, array $data = []): ?Link
    {
        $site = $this->dataResolver->get(OnlineStore::class)->getSite();

        if ($site === null || ($document = Site::getById((int)$site)?->getRootDocument()) === null) {
            return null;
        }

        $maxDepth = $data['maxDepth'] ?? null;

        return $this->getLinks($document, $maxDepth);
    }

    private function getLinks(Document $document, ?int $maxDepth = null, int $currentDepth = 0): ?Link
    {
        if ($document instanceof Document\Hardlink) {
            $document = $document->getSourceDocument();
        }

        if ($document !== null && !$document->getProperty('navigation_exclude') && method_exists($document, 'getHref')) {
            $link = new Link(
                $document->getProperty('navigation_name'),
                $document->getHref()
            );

            if ($document->hasChildren() && ($maxDepth === null || $currentDepth < $maxDepth)) {
                foreach ($document->getChildren() as $child) {
                    if (!$child) {
                        continue;
                    }

                    $childLink = $this->getLinks($child, $maxDepth, $currentDepth + 1);

                    if ($childLink !== null) {
                        $link->addChild($childLink);
                    }
                }
            }

            return $link;
        }

        return null;
    }
}
