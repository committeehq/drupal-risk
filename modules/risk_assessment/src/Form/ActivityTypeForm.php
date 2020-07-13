<?php

namespace Drupal\risk_assessment\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Form\ParagraphsTypeForm;

/**
 * Class ActivityTypeForm.
 */
class ActivityTypeForm extends ParagraphsTypeForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $risk_assessment_activity_type = $this->entity;
    $status = $risk_assessment_activity_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Activity type.', [
          '%label' => $risk_assessment_activity_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Activity type.', [
          '%label' => $risk_assessment_activity_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($risk_assessment_activity_type->toUrl('collection'));
  }

}
