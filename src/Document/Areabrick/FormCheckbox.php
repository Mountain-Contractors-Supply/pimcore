<?php

declare(strict_types=1);

namespace App\Document\Areabrick;

use Pimcore\Extension\Document\Areabrick\Attribute\AsAreabrick;
use Pimcore\Extension\Document\Areabrick\EditableDialogBoxConfiguration;
use Pimcore\Model\Document;
use Pimcore\Model\Document\Editable;
use Pimcore\Model\Document\Editable\Area\Info;
use Symfony\Component\HttpFoundation\Response;

#[AsAreabrick(id: 'form-checkbox')]
final class FormCheckbox extends AbstractConfigurableAreabrick
{
    public function getName(): string
    {
        return 'Checkbox Field';
    }

    public function getDescription(): string
    {
        return 'A checkbox input field with style and size variants';
    }

    public function getComponentClassName(): string
    {
        return \McSupply\EcommerceBundle\Twig\Components\Form\Checkbox::class;
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
                (new Editable\Checkbox())->setName('checked')->setLabel('Checked by Default'),
                (new Editable\Checkbox())->setName('disabled')->setLabel('Disabled'),
            ],
        ];

        $config->setItems(['type' => 'tabpanel', 'items' => $items]);

        return $config;
    }

    #[\Override]
    public function action(Info $info): ?Response
    {
        parent::action($info);

        $info->setParam('name', $info->getDocumentElement('name')?->getData() ?? 'checkbox');
        $info->setParam('checked', (bool) $info->getDocumentElement('checked')?->getData());
        $info->setParam('disabled', (bool) $info->getDocumentElement('disabled')?->getData());

        return null;
    }
}
