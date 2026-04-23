<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxConfiguration;
use Pimcore\Model\Document;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;
use Symfony\Component\HttpFoundation\Response;

#[AsAreabrick(id: 'form-select')]
final class FormSelect extends AbstractConfigurableAreabrick
{
    public function getName(): string
    {
        return 'Select Dropdown';
    }

    public function getDescription(): string
    {
        return 'A select dropdown field with size variants';
    }

    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Form\Select::class;
    }

    #[\Override]
    public function getEditableDialogBoxConfiguration(Document\Editable $area, ?Info $info): EditableDialogBoxConfiguration
    {
        $config = parent::getEditableDialogBoxConfiguration($area, $info);
        $items = $config->getItems()['items'] ?? [];

        $items[] = [
            'type' => 'panel',
            'title' => 'Field Properties',
            'items' => [
                (new Editable\Input())->setName('name')->setLabel('Field Name'),
                (new Editable\Input())->setName('id')->setLabel('Field ID'),
                (new Editable\Input())->setName('label')->setLabel('Label Text'),
                (new Editable\Input())->setName('selectedValue')->setLabel('Selected Value'),
                (new Editable\Checkbox())->setName('disabled')->setLabel('Disabled'),
                (new Editable\Checkbox())->setName('required')->setLabel('Required'),
            ],
        ];

        $config->setItems(['type' => 'tabpanel', 'items' => $items]);

        return $config;
    }

    #[\Override]
    public function action(Info $info): ?Response
    {
        parent::action($info);

        $info->setParam('name', $info->getDocumentElement('name')?->getData() ?? 'select');
        $info->setParam('id', $info->getDocumentElement('id')?->getData() ?? '');
        $info->setParam('label', $info->getDocumentElement('label')?->getData() ?? 'Label');
        $info->setParam('selectedValue', $info->getDocumentElement('selectedValue')?->getData() ?? '');
        $info->setParam('disabled', (bool) $info->getDocumentElement('disabled')?->getData());
        $info->setParam('required', (bool) $info->getDocumentElement('required')?->getData());

        return null;
    }
}
