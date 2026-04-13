<?php

declare(strict_types=1);

namespace App\EventListener;

use Pimcore\Bundle\GenericDataIndexBundle\Event\DataObject\ExtractMappingEvent;
use Pimcore\Bundle\GenericDataIndexBundle\Event\DataObject\UpdateIndexDataEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

final class DataObjectIndexListener
{
    #[AsEventListener(event: UpdateIndexDataEvent::class)]
    public function onUpdateIndexData(UpdateIndexDataEvent $event): void
    {
        $dataObject = $event->getElement();

        if ($dataObject instanceof CustomIndexModifierInterface) {
            $event->setCustomFields($dataObject->modifyCustomFields($event->getCustomFields()));
        }
    }

    #[AsEventListener(event: ExtractMappingEvent::class)]
    public function onExtractMapping(ExtractMappingEvent $event): void
    {
        $class = 'Pimcore\\Model\\DataObject\\' . ucfirst((string)$event->getClassDefinition()->getName());

        if (is_a($class, CustomIndexModifierInterface::class, true)) {
            $event->setCustomFieldsMapping(call_user_func([$class, 'modifyCustomMapping'], $event->getCustomFieldsMapping()));
        }
    }
}
