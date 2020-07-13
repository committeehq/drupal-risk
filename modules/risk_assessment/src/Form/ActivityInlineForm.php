<?php


namespace Drupal\risk_assessment\Form;


class ActivityInlineForm extends \Drupal\inline_entity_form\Form\EntityInlineForm
{

  /**
   * {@inheritdoc}
   */
  public function getTableFields($bundles) {
    $fields = parent::getTableFields($bundles);
    $fields['label']['label'] = t('Title');
    $fields['description'] = [
      'type' => 'field',
      'label' => t('Description'),
      'weight' => 10,
      'display_options' => [
        'type' => 'text_trimmed',
        'settings' => [
          'trim_length' => '140'
        ]
      ]
    ];

    return $fields;
  }
}
