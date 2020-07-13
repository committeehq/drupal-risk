<?php

namespace Drupal\risk_assessment\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Form\ParagraphsTypeForm;

/**
 * Class HazardTypeForm.
 */
class HazardTypeForm extends ParagraphsTypeForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $risk_assessment_hazard_type = $this->entity;
    $status = $risk_assessment_hazard_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Hazard type.', [
          '%label' => $risk_assessment_hazard_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Hazard type.', [
          '%label' => $risk_assessment_hazard_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($risk_assessment_hazard_type->toUrl('collection'));
  }

}
