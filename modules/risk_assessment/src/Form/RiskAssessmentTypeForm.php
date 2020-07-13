<?php

namespace Drupal\risk_assessment\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class RiskAssessmentTypeForm.
 */
class RiskAssessmentTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $risk_assessment_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $risk_assessment_type->label(),
      '#description' => $this->t("Label for the Risk assessment type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $risk_assessment_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\risk_assessment\Entity\RiskAssessmentType::load',
      ],
      '#disabled' => !$risk_assessment_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $risk_assessment_type = $this->entity;
    $status = $risk_assessment_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Risk assessment type.', [
          '%label' => $risk_assessment_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Risk assessment type.', [
          '%label' => $risk_assessment_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($risk_assessment_type->toUrl('collection'));
  }

}
