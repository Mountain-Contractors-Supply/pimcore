<?php

declare(strict_types=1);

namespace App\EventListener;

use Pimcore\Event\DataObjectEvents;
use Pimcore\Event\Model\AssetEvent;
use Pimcore\Event\Model\DataObjectEvent;
use Pimcore\Event\Model\DocumentEvent;
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Model\Element\AbstractElement;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(event: DataObjectEvents::PRE_ADD, method: 'onPreAdd', priority: -100)]
#[AsEventListener(event: DataObjectEvents::PRE_UPDATE, method: 'onPreUpdate', priority: -100)]
#[AsEventListener(event: DataObjectEvents::POST_ADD, method: 'onPostAdd', priority: -100)]
#[AsEventListener(event: DataObjectEvents::POST_UPDATE, method: 'onPostUpdate', priority: -100)]
final class ObjectListener
{
    /**
     * @param ElementEventInterface $e
     * @return void
     */
    public function onPreAdd(ElementEventInterface $e): void
    {
        $object = $this->resolveObject($e);

        if ($object instanceof PreAddUpdateAwareInterface) {
            $object->onPreAdd();
        }
    }

    /**
     * @param ElementEventInterface $e
     * @return void
     */
    public function onPreUpdate(ElementEventInterface $e): void
    {
        $object = $this->resolveObject($e);

        if ($object instanceof PreAddUpdateAwareInterface) {
            $object->onPreUpdate();
        }
    }

    public function onPostAdd(ElementEventInterface $e): void
    {
        $object = $this->resolveObject($e);

        if ($object instanceof PostAddUpdateAwareInterface) {
            $object->onPostAdd();
        }
    }

    public function onPostUpdate(ElementEventInterface $e): void
    {
        $object = $this->resolveObject($e);

        if ($object instanceof PostAddUpdateAwareInterface) {
            $object->onPostUpdate();
        }
    }

    private function resolveObject(ElementEventInterface $e): ?AbstractElement
    {
        return match (true) {
            $e instanceof DataObjectEvent => $e->getObject(),
            $e instanceof DocumentEvent => $e->getDocument(),
            $e instanceof AssetEvent => $e->getAsset(),
            default => null,
        };
    }
}
