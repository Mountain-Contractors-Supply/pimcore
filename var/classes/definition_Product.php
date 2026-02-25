<?php

/**
 * Inheritance: no
 * Variants: no
 *
 * Fields Summary:
 * - localizedfields [localizedfields]
 * -- name [input]
 * -- description [wysiwyg]
 * -- features [wysiwyg]
 * - productId [input]
 * - brand [calculatedValue]
 * - modelNumber [input]
 * - status [select]
 * - upc [input]
 * - categoriesRef [manyToManyObjectRelation]
 * - widthRef [quantityValue]
 * - heightRef [quantityValue]
 * - lengthRef [quantityValue]
 * - weightRef [quantityValue]
 */

return \Pimcore\Model\DataObject\ClassDefinition::__set_state(array(
   'dao' => NULL,
   'id' => 'product',
   'name' => 'Product',
   'title' => '',
   'description' => '',
   'creationDate' => NULL,
   'modificationDate' => 1772032540,
   'userOwner' => 2,
   'userModification' => 2,
   'parentClass' => 'App\\Model\\Product\\AbstractProduct',
   'implementsInterfaces' => '',
   'listingParentClass' => '',
   'useTraits' => '',
   'listingUseTraits' => '',
   'encryption' => false,
   'encryptedTables' => 
  array (
  ),
   'allowInherit' => false,
   'allowVariants' => false,
   'showVariants' => false,
   'layoutDefinitions' => 
  \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
     'name' => 'pimcore_root',
     'type' => NULL,
     'region' => NULL,
     'title' => NULL,
     'width' => 0,
     'height' => 0,
     'collapsible' => false,
     'collapsed' => false,
     'bodyStyle' => NULL,
     'datatype' => 'layout',
     'children' => 
    array (
      0 => 
      \Pimcore\Model\DataObject\ClassDefinition\Layout\Region::__set_state(array(
         'name' => 'Layout',
         'type' => NULL,
         'region' => '',
         'title' => '',
         'width' => '',
         'height' => '',
         'collapsible' => false,
         'collapsed' => false,
         'bodyStyle' => '',
         'datatype' => 'layout',
         'children' => 
        array (
          0 => 
          \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
             'name' => 'Primary Information',
             'type' => NULL,
             'region' => 'north',
             'title' => 'Primary Information',
             'width' => '',
             'height' => '',
             'collapsible' => true,
             'collapsed' => false,
             'bodyStyle' => '',
             'datatype' => 'layout',
             'children' => 
            array (
              0 => 
              \Pimcore\Model\DataObject\ClassDefinition\Layout\Region::__set_state(array(
                 'name' => 'Layout',
                 'type' => NULL,
                 'region' => NULL,
                 'title' => '',
                 'width' => '',
                 'height' => 350,
                 'collapsible' => false,
                 'collapsed' => false,
                 'bodyStyle' => '',
                 'datatype' => 'layout',
                 'children' => 
                array (
                  0 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
                     'name' => 'Layout',
                     'type' => NULL,
                     'region' => 'north',
                     'title' => '',
                     'width' => '',
                     'height' => '',
                     'collapsible' => false,
                     'collapsed' => false,
                     'bodyStyle' => '',
                     'datatype' => 'layout',
                     'children' => 
                    array (
                      0 => 
                      \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields::__set_state(array(
                         'name' => 'localizedfields',
                         'title' => '',
                         'tooltip' => NULL,
                         'mandatory' => false,
                         'noteditable' => false,
                         'index' => false,
                         'locked' => false,
                         'style' => NULL,
                         'permissions' => NULL,
                         'fieldtype' => '',
                         'relationType' => false,
                         'invisible' => false,
                         'visibleGridView' => true,
                         'visibleSearch' => true,
                         'blockedVarsForExport' => 
                        array (
                        ),
                         'children' => 
                        array (
                          0 => 
                          \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
                             'name' => 'name',
                             'title' => 'Name',
                             'tooltip' => '',
                             'mandatory' => true,
                             'noteditable' => false,
                             'index' => true,
                             'locked' => false,
                             'style' => '',
                             'permissions' => NULL,
                             'fieldtype' => '',
                             'relationType' => false,
                             'invisible' => false,
                             'visibleGridView' => false,
                             'visibleSearch' => false,
                             'blockedVarsForExport' => 
                            array (
                            ),
                             'defaultValue' => '',
                             'columnLength' => 190,
                             'regex' => '',
                             'regexFlags' => 
                            array (
                            ),
                             'unique' => false,
                             'showCharCount' => false,
                             'width' => '',
                             'defaultValueGenerator' => '',
                          )),
                        ),
                         'region' => NULL,
                         'layout' => NULL,
                         'maxTabs' => NULL,
                         'border' => false,
                         'provideSplitView' => false,
                         'tabPosition' => 'top',
                         'hideLabelsWhenTabsReached' => NULL,
                         'referencedFields' => 
                        array (
                          0 => 
                          \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields::__set_state(array(
                             'name' => 'localizedfields',
                             'title' => '',
                             'tooltip' => NULL,
                             'mandatory' => false,
                             'noteditable' => false,
                             'index' => false,
                             'locked' => false,
                             'style' => NULL,
                             'permissions' => NULL,
                             'fieldtype' => '',
                             'relationType' => false,
                             'invisible' => false,
                             'visibleGridView' => true,
                             'visibleSearch' => true,
                             'blockedVarsForExport' => 
                            array (
                            ),
                             'children' => 
                            array (
                              0 => 
                              \Pimcore\Model\DataObject\ClassDefinition\Data\Wysiwyg::__set_state(array(
                                 'name' => 'description',
                                 'title' => 'Description',
                                 'tooltip' => '',
                                 'mandatory' => false,
                                 'noteditable' => false,
                                 'index' => false,
                                 'locked' => false,
                                 'style' => '',
                                 'permissions' => NULL,
                                 'fieldtype' => '',
                                 'relationType' => false,
                                 'invisible' => false,
                                 'visibleGridView' => false,
                                 'visibleSearch' => false,
                                 'blockedVarsForExport' => 
                                array (
                                ),
                                 'toolbarConfig' => '',
                                 'excludeFromSearchIndex' => false,
                                 'maxCharacters' => '',
                                 'height' => '',
                                 'width' => '',
                              )),
                            ),
                             'region' => NULL,
                             'layout' => NULL,
                             'maxTabs' => NULL,
                             'border' => false,
                             'provideSplitView' => false,
                             'tabPosition' => 'top',
                             'hideLabelsWhenTabsReached' => NULL,
                             'referencedFields' => 
                            array (
                            ),
                             'permissionView' => NULL,
                             'permissionEdit' => NULL,
                             'labelWidth' => 100,
                             'labelAlign' => 'left',
                             'width' => '',
                             'height' => '',
                             'fieldDefinitionsCache' => NULL,
                          )),
                          1 => 
                          \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields::__set_state(array(
                             'name' => 'localizedfields',
                             'title' => '',
                             'tooltip' => NULL,
                             'mandatory' => false,
                             'noteditable' => false,
                             'index' => false,
                             'locked' => false,
                             'style' => NULL,
                             'permissions' => NULL,
                             'fieldtype' => '',
                             'relationType' => false,
                             'invisible' => false,
                             'visibleGridView' => true,
                             'visibleSearch' => true,
                             'blockedVarsForExport' => 
                            array (
                            ),
                             'children' => 
                            array (
                              0 => 
                              \Pimcore\Model\DataObject\ClassDefinition\Data\Wysiwyg::__set_state(array(
                                 'name' => 'features',
                                 'title' => 'Features',
                                 'tooltip' => '',
                                 'mandatory' => false,
                                 'noteditable' => false,
                                 'index' => false,
                                 'locked' => false,
                                 'style' => '',
                                 'permissions' => NULL,
                                 'fieldtype' => '',
                                 'relationType' => false,
                                 'invisible' => false,
                                 'visibleGridView' => false,
                                 'visibleSearch' => false,
                                 'blockedVarsForExport' => 
                                array (
                                ),
                                 'toolbarConfig' => '',
                                 'excludeFromSearchIndex' => false,
                                 'maxCharacters' => '',
                                 'height' => '',
                                 'width' => '',
                              )),
                            ),
                             'region' => NULL,
                             'layout' => NULL,
                             'maxTabs' => NULL,
                             'border' => false,
                             'provideSplitView' => false,
                             'tabPosition' => 'top',
                             'hideLabelsWhenTabsReached' => NULL,
                             'referencedFields' => 
                            array (
                            ),
                             'permissionView' => NULL,
                             'permissionEdit' => NULL,
                             'labelWidth' => 100,
                             'labelAlign' => 'left',
                             'width' => '',
                             'height' => '',
                             'fieldDefinitionsCache' => NULL,
                          )),
                        ),
                         'permissionView' => NULL,
                         'permissionEdit' => NULL,
                         'labelWidth' => 100,
                         'labelAlign' => 'left',
                         'width' => '',
                         'height' => '',
                         'fieldDefinitionsCache' => NULL,
                      )),
                      1 => 
                      \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
                         'name' => 'productId',
                         'title' => 'Product Id',
                         'tooltip' => '',
                         'mandatory' => true,
                         'noteditable' => true,
                         'index' => true,
                         'locked' => false,
                         'style' => '',
                         'permissions' => NULL,
                         'fieldtype' => '',
                         'relationType' => false,
                         'invisible' => true,
                         'visibleGridView' => true,
                         'visibleSearch' => true,
                         'blockedVarsForExport' => 
                        array (
                        ),
                         'defaultValue' => '',
                         'columnLength' => 190,
                         'regex' => '',
                         'regexFlags' => 
                        array (
                        ),
                         'unique' => true,
                         'showCharCount' => false,
                         'width' => '',
                         'defaultValueGenerator' => '',
                      )),
                    ),
                     'locked' => false,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'fieldtype' => 'panel',
                     'layout' => NULL,
                     'border' => false,
                     'icon' => '',
                     'labelWidth' => 100,
                     'labelAlign' => 'left',
                  )),
                  1 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
                     'name' => 'Layout',
                     'type' => NULL,
                     'region' => 'west',
                     'title' => '',
                     'width' => '',
                     'height' => '',
                     'collapsible' => false,
                     'collapsed' => false,
                     'bodyStyle' => '',
                     'datatype' => 'layout',
                     'children' => 
                    array (
                      0 => 
                      \Pimcore\Model\DataObject\ClassDefinition\Data\CalculatedValue::__set_state(array(
                         'name' => 'brand',
                         'title' => 'Brand',
                         'tooltip' => '',
                         'mandatory' => false,
                         'noteditable' => false,
                         'index' => false,
                         'locked' => false,
                         'style' => '',
                         'permissions' => NULL,
                         'fieldtype' => '',
                         'relationType' => false,
                         'invisible' => false,
                         'visibleGridView' => false,
                         'visibleSearch' => false,
                         'blockedVarsForExport' => 
                        array (
                        ),
                         'elementType' => 'input',
                         'calculatorType' => 'expression',
                         'calculatorExpression' => 'object.getBrandName()',
                         'calculatorClass' => '',
                         'columnLength' => 190,
                         'width' => 350,
                      )),
                      1 => 
                      \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
                         'name' => 'modelNumber',
                         'title' => 'Model Number',
                         'tooltip' => '',
                         'mandatory' => false,
                         'noteditable' => false,
                         'index' => false,
                         'locked' => false,
                         'style' => '',
                         'permissions' => NULL,
                         'fieldtype' => '',
                         'relationType' => false,
                         'invisible' => false,
                         'visibleGridView' => false,
                         'visibleSearch' => false,
                         'blockedVarsForExport' => 
                        array (
                        ),
                         'defaultValue' => '',
                         'columnLength' => 190,
                         'regex' => '',
                         'regexFlags' => 
                        array (
                        ),
                         'unique' => false,
                         'showCharCount' => false,
                         'width' => 200,
                         'defaultValueGenerator' => '',
                      )),
                    ),
                     'locked' => false,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'fieldtype' => 'panel',
                     'layout' => NULL,
                     'border' => false,
                     'icon' => '',
                     'labelWidth' => 100,
                     'labelAlign' => 'left',
                  )),
                  2 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
                     'name' => 'Layout',
                     'type' => NULL,
                     'region' => 'west',
                     'title' => '',
                     'width' => '',
                     'height' => '',
                     'collapsible' => false,
                     'collapsed' => false,
                     'bodyStyle' => '',
                     'datatype' => 'layout',
                     'children' => 
                    array (
                      0 => 
                      \Pimcore\Model\DataObject\ClassDefinition\Data\Select::__set_state(array(
                         'name' => 'status',
                         'title' => 'Status',
                         'tooltip' => '',
                         'mandatory' => false,
                         'noteditable' => true,
                         'index' => false,
                         'locked' => false,
                         'style' => '',
                         'permissions' => NULL,
                         'fieldtype' => '',
                         'relationType' => false,
                         'invisible' => false,
                         'visibleGridView' => false,
                         'visibleSearch' => false,
                         'blockedVarsForExport' => 
                        array (
                        ),
                         'defaultValue' => '',
                         'columnLength' => 190,
                         'dynamicOptions' => false,
                         'enforceValidation' => false,
                         'defaultValueGenerator' => '',
                         'width' => '',
                         'optionsProviderType' => 'select_options',
                         'optionsProviderClass' => 'Pimcore\\Bundle\\CoreBundle\\OptionsProvider\\SelectOptionsOptionsProvider',
                         'optionsProviderData' => 'ProductStatus',
                      )),
                      1 => 
                      \Pimcore\Model\DataObject\ClassDefinition\Data\Input::__set_state(array(
                         'name' => 'upc',
                         'title' => 'UPC',
                         'tooltip' => '',
                         'mandatory' => false,
                         'noteditable' => false,
                         'index' => false,
                         'locked' => false,
                         'style' => '',
                         'permissions' => NULL,
                         'fieldtype' => '',
                         'relationType' => false,
                         'invisible' => false,
                         'visibleGridView' => false,
                         'visibleSearch' => false,
                         'blockedVarsForExport' => 
                        array (
                        ),
                         'defaultValue' => '',
                         'columnLength' => 190,
                         'regex' => '',
                         'regexFlags' => 
                        array (
                        ),
                         'unique' => false,
                         'showCharCount' => false,
                         'width' => 150,
                         'defaultValueGenerator' => '',
                      )),
                    ),
                     'locked' => false,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'fieldtype' => 'panel',
                     'layout' => NULL,
                     'border' => false,
                     'icon' => '',
                     'labelWidth' => 100,
                     'labelAlign' => 'left',
                  )),
                ),
                 'locked' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'fieldtype' => 'region',
                 'icon' => '',
              )),
            ),
             'locked' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'fieldtype' => 'panel',
             'layout' => NULL,
             'border' => true,
             'icon' => '',
             'labelWidth' => 100,
             'labelAlign' => 'left',
          )),
          1 => 
          \Pimcore\Model\DataObject\ClassDefinition\Layout\Tabpanel::__set_state(array(
             'name' => 'Layout',
             'type' => NULL,
             'region' => 'north',
             'title' => 'Additional Information',
             'width' => '',
             'height' => '',
             'collapsible' => true,
             'collapsed' => false,
             'bodyStyle' => '',
             'datatype' => 'layout',
             'children' => 
            array (
              0 => 
              \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
                 'name' => 'Description & Features',
                 'type' => NULL,
                 'region' => NULL,
                 'title' => 'Description & Features',
                 'width' => '',
                 'height' => '',
                 'collapsible' => false,
                 'collapsed' => false,
                 'bodyStyle' => '',
                 'datatype' => 'layout',
                 'children' => 
                array (
                  0 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields::__set_state(array(
                     'name' => 'localizedfields',
                     'title' => '',
                     'tooltip' => NULL,
                     'mandatory' => false,
                     'noteditable' => false,
                     'index' => false,
                     'locked' => false,
                     'style' => NULL,
                     'permissions' => NULL,
                     'fieldtype' => '',
                     'relationType' => false,
                     'invisible' => false,
                     'visibleGridView' => true,
                     'visibleSearch' => true,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'children' => 
                    array (
                      0 => 
                      \Pimcore\Model\DataObject\ClassDefinition\Data\Wysiwyg::__set_state(array(
                         'name' => 'description',
                         'title' => 'Description',
                         'tooltip' => '',
                         'mandatory' => false,
                         'noteditable' => false,
                         'index' => false,
                         'locked' => false,
                         'style' => '',
                         'permissions' => NULL,
                         'fieldtype' => '',
                         'relationType' => false,
                         'invisible' => false,
                         'visibleGridView' => false,
                         'visibleSearch' => false,
                         'blockedVarsForExport' => 
                        array (
                        ),
                         'toolbarConfig' => '',
                         'excludeFromSearchIndex' => false,
                         'maxCharacters' => '',
                         'height' => '',
                         'width' => '',
                      )),
                    ),
                     'region' => NULL,
                     'layout' => NULL,
                     'maxTabs' => NULL,
                     'border' => false,
                     'provideSplitView' => false,
                     'tabPosition' => 'top',
                     'hideLabelsWhenTabsReached' => NULL,
                     'referencedFields' => 
                    array (
                    ),
                     'permissionView' => NULL,
                     'permissionEdit' => NULL,
                     'labelWidth' => 100,
                     'labelAlign' => 'left',
                     'width' => '',
                     'height' => '',
                     'fieldDefinitionsCache' => NULL,
                  )),
                  1 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Data\Localizedfields::__set_state(array(
                     'name' => 'localizedfields',
                     'title' => '',
                     'tooltip' => NULL,
                     'mandatory' => false,
                     'noteditable' => false,
                     'index' => false,
                     'locked' => false,
                     'style' => NULL,
                     'permissions' => NULL,
                     'fieldtype' => '',
                     'relationType' => false,
                     'invisible' => false,
                     'visibleGridView' => true,
                     'visibleSearch' => true,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'children' => 
                    array (
                      0 => 
                      \Pimcore\Model\DataObject\ClassDefinition\Data\Wysiwyg::__set_state(array(
                         'name' => 'features',
                         'title' => 'Features',
                         'tooltip' => '',
                         'mandatory' => false,
                         'noteditable' => false,
                         'index' => false,
                         'locked' => false,
                         'style' => '',
                         'permissions' => NULL,
                         'fieldtype' => '',
                         'relationType' => false,
                         'invisible' => false,
                         'visibleGridView' => false,
                         'visibleSearch' => false,
                         'blockedVarsForExport' => 
                        array (
                        ),
                         'toolbarConfig' => '',
                         'excludeFromSearchIndex' => false,
                         'maxCharacters' => '',
                         'height' => '',
                         'width' => '',
                      )),
                    ),
                     'region' => NULL,
                     'layout' => NULL,
                     'maxTabs' => NULL,
                     'border' => false,
                     'provideSplitView' => false,
                     'tabPosition' => 'top',
                     'hideLabelsWhenTabsReached' => NULL,
                     'referencedFields' => 
                    array (
                    ),
                     'permissionView' => NULL,
                     'permissionEdit' => NULL,
                     'labelWidth' => 100,
                     'labelAlign' => 'left',
                     'width' => '',
                     'height' => '',
                     'fieldDefinitionsCache' => NULL,
                  )),
                ),
                 'locked' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'fieldtype' => 'panel',
                 'layout' => NULL,
                 'border' => false,
                 'icon' => '',
                 'labelWidth' => 100,
                 'labelAlign' => 'left',
              )),
              1 => 
              \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
                 'name' => 'Categories',
                 'type' => NULL,
                 'region' => NULL,
                 'title' => 'Categories',
                 'width' => '',
                 'height' => '',
                 'collapsible' => false,
                 'collapsed' => false,
                 'bodyStyle' => '',
                 'datatype' => 'layout',
                 'children' => 
                array (
                  0 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Data\ManyToManyObjectRelation::__set_state(array(
                     'name' => 'categoriesRef',
                     'title' => 'Categories',
                     'tooltip' => '',
                     'mandatory' => false,
                     'noteditable' => false,
                     'index' => false,
                     'locked' => false,
                     'style' => '',
                     'permissions' => NULL,
                     'fieldtype' => '',
                     'relationType' => true,
                     'invisible' => false,
                     'visibleGridView' => false,
                     'visibleSearch' => false,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'classes' => 
                    array (
                      0 => 
                      array (
                        'classes' => 'ProductCategory',
                      ),
                    ),
                     'displayMode' => 'grid',
                     'pathFormatterClass' => '',
                     'maxItems' => NULL,
                     'visibleFields' => 
                    array (
                    ),
                     'allowToCreateNewObject' => false,
                     'allowToClearRelation' => true,
                     'optimizedAdminLoading' => false,
                     'enableTextSelection' => false,
                     'visibleFieldDefinitions' => 
                    array (
                    ),
                     'width' => '',
                     'height' => '',
                  )),
                ),
                 'locked' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'fieldtype' => 'panel',
                 'layout' => NULL,
                 'border' => false,
                 'icon' => '',
                 'labelWidth' => 100,
                 'labelAlign' => 'left',
              )),
              2 => 
              \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
                 'name' => 'Attributes',
                 'type' => NULL,
                 'region' => NULL,
                 'title' => 'Attributes',
                 'width' => '',
                 'height' => '',
                 'collapsible' => false,
                 'collapsed' => false,
                 'bodyStyle' => '',
                 'datatype' => 'layout',
                 'children' => 
                array (
                ),
                 'locked' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'fieldtype' => 'panel',
                 'layout' => NULL,
                 'border' => false,
                 'icon' => '',
                 'labelWidth' => 100,
                 'labelAlign' => 'left',
              )),
              3 => 
              \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
                 'name' => 'Media',
                 'type' => NULL,
                 'region' => NULL,
                 'title' => 'Media',
                 'width' => '',
                 'height' => '',
                 'collapsible' => false,
                 'collapsed' => false,
                 'bodyStyle' => '',
                 'datatype' => 'layout',
                 'children' => 
                array (
                ),
                 'locked' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'fieldtype' => 'panel',
                 'layout' => NULL,
                 'border' => false,
                 'icon' => '',
                 'labelWidth' => 100,
                 'labelAlign' => 'left',
              )),
              4 => 
              \Pimcore\Model\DataObject\ClassDefinition\Layout\Panel::__set_state(array(
                 'name' => 'Specs',
                 'type' => NULL,
                 'region' => NULL,
                 'title' => 'Specs',
                 'width' => '',
                 'height' => '',
                 'collapsible' => false,
                 'collapsed' => false,
                 'bodyStyle' => '',
                 'datatype' => 'layout',
                 'children' => 
                array (
                  0 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Data\QuantityValue::__set_state(array(
                     'name' => 'widthRef',
                     'title' => 'Width',
                     'tooltip' => '',
                     'mandatory' => false,
                     'noteditable' => false,
                     'index' => false,
                     'locked' => false,
                     'style' => '',
                     'permissions' => NULL,
                     'fieldtype' => '',
                     'relationType' => false,
                     'invisible' => false,
                     'visibleGridView' => false,
                     'visibleSearch' => false,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'unitWidth' => '',
                     'defaultUnit' => NULL,
                     'validUnits' => 
                    array (
                      0 => 'in',
                      1 => 'ft',
                    ),
                     'unique' => false,
                     'autoConvert' => false,
                     'defaultValueGenerator' => '',
                     'width' => '',
                     'defaultValue' => NULL,
                     'integer' => false,
                     'unsigned' => false,
                     'minValue' => NULL,
                     'maxValue' => NULL,
                     'decimalSize' => NULL,
                     'decimalPrecision' => NULL,
                  )),
                  1 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Data\QuantityValue::__set_state(array(
                     'name' => 'heightRef',
                     'title' => 'Height',
                     'tooltip' => '',
                     'mandatory' => false,
                     'noteditable' => false,
                     'index' => false,
                     'locked' => false,
                     'style' => '',
                     'permissions' => NULL,
                     'fieldtype' => '',
                     'relationType' => false,
                     'invisible' => false,
                     'visibleGridView' => false,
                     'visibleSearch' => false,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'unitWidth' => '',
                     'defaultUnit' => NULL,
                     'validUnits' => 
                    array (
                      0 => 'in',
                      1 => 'ft',
                    ),
                     'unique' => false,
                     'autoConvert' => false,
                     'defaultValueGenerator' => '',
                     'width' => '',
                     'defaultValue' => NULL,
                     'integer' => false,
                     'unsigned' => false,
                     'minValue' => NULL,
                     'maxValue' => NULL,
                     'decimalSize' => NULL,
                     'decimalPrecision' => NULL,
                  )),
                  2 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Data\QuantityValue::__set_state(array(
                     'name' => 'lengthRef',
                     'title' => 'Length',
                     'tooltip' => '',
                     'mandatory' => false,
                     'noteditable' => false,
                     'index' => false,
                     'locked' => false,
                     'style' => '',
                     'permissions' => NULL,
                     'fieldtype' => '',
                     'relationType' => false,
                     'invisible' => false,
                     'visibleGridView' => false,
                     'visibleSearch' => false,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'unitWidth' => '',
                     'defaultUnit' => NULL,
                     'validUnits' => 
                    array (
                      0 => 'in',
                      1 => 'ft',
                    ),
                     'unique' => false,
                     'autoConvert' => false,
                     'defaultValueGenerator' => '',
                     'width' => '',
                     'defaultValue' => NULL,
                     'integer' => false,
                     'unsigned' => false,
                     'minValue' => NULL,
                     'maxValue' => NULL,
                     'decimalSize' => NULL,
                     'decimalPrecision' => NULL,
                  )),
                  3 => 
                  \Pimcore\Model\DataObject\ClassDefinition\Data\QuantityValue::__set_state(array(
                     'name' => 'weightRef',
                     'title' => 'Weight',
                     'tooltip' => '',
                     'mandatory' => false,
                     'noteditable' => false,
                     'index' => false,
                     'locked' => false,
                     'style' => '',
                     'permissions' => NULL,
                     'fieldtype' => '',
                     'relationType' => false,
                     'invisible' => false,
                     'visibleGridView' => false,
                     'visibleSearch' => false,
                     'blockedVarsForExport' => 
                    array (
                    ),
                     'unitWidth' => '',
                     'defaultUnit' => NULL,
                     'validUnits' => 
                    array (
                      0 => 'oz',
                      1 => 'lb',
                    ),
                     'unique' => false,
                     'autoConvert' => false,
                     'defaultValueGenerator' => '',
                     'width' => '',
                     'defaultValue' => NULL,
                     'integer' => false,
                     'unsigned' => false,
                     'minValue' => NULL,
                     'maxValue' => NULL,
                     'decimalSize' => NULL,
                     'decimalPrecision' => NULL,
                  )),
                ),
                 'locked' => false,
                 'blockedVarsForExport' => 
                array (
                ),
                 'fieldtype' => 'panel',
                 'layout' => NULL,
                 'border' => false,
                 'icon' => '',
                 'labelWidth' => 100,
                 'labelAlign' => 'left',
              )),
            ),
             'locked' => false,
             'blockedVarsForExport' => 
            array (
            ),
             'fieldtype' => 'tabpanel',
             'border' => true,
             'tabPosition' => 'top',
          )),
        ),
         'locked' => false,
         'blockedVarsForExport' => 
        array (
        ),
         'fieldtype' => 'region',
         'icon' => '',
      )),
    ),
     'locked' => false,
     'blockedVarsForExport' => 
    array (
    ),
     'fieldtype' => 'panel',
     'layout' => NULL,
     'border' => false,
     'icon' => NULL,
     'labelWidth' => 100,
     'labelAlign' => 'left',
  )),
   'icon' => '',
   'group' => 'Product',
   'showAppLoggerTab' => false,
   'linkGeneratorReference' => '@App\\LinkGenerator\\ProductLinkGenerator',
   'previewGeneratorReference' => '@App\\PreviewGenerator\\ProductPreviewGenerator',
   'compositeIndices' => 
  array (
  ),
   'showFieldLookup' => false,
   'propertyVisibility' => 
  array (
    'grid' => 
    array (
      'id' => true,
      'key' => false,
      'path' => true,
      'published' => true,
      'modificationDate' => true,
      'creationDate' => true,
    ),
    'search' => 
    array (
      'id' => true,
      'key' => false,
      'path' => true,
      'published' => true,
      'modificationDate' => true,
      'creationDate' => true,
    ),
  ),
   'enableGridLocking' => false,
   'deletedDataComponents' => 
  array (
  ),
   'blockedVarsForExport' => 
  array (
  ),
   'fieldDefinitionsCache' => 
  array (
  ),
   'activeDispatchingEvents' => 
  array (
  ),
));
