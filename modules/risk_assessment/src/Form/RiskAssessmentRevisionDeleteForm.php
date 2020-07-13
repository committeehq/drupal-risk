<?php

namespace Drupal\risk_assessment\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Risk assessment revision.
 *
 * @ingroup risk_assessment
 */
class RiskAssessmentRevisionDeleteForm extends ConfirmFormBase {

  /**
   * The Risk assessment revision.
   *
   * @var \Drupal\risk_assessment\Entity\RiskAssessmentInterface
   */
  protected $revision;

  /**
   * The Risk assessment storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $riskAssessmentStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->riskAssessmentStorage = $container->get('entity_type.manager')->getStorage('risk_assessment');
    $instance->connection = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'risk_assessment_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the revision from %revision-date?', [
      '%revision-date' => format_date($this->revision->getRevisionCreationTime()),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.risk_assessment.version_history', ['risk_assessment' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $risk_assessment_revision = NULL) {
    $this->revision = $this->RiskAssessmentStorage->loadRevision($risk_assessment_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->RiskAssessmentStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('Risk assessment: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()]);
    $this->messenger()->addMessage(t('Revision from %revision-date of Risk assessment %title has been deleted.', ['%revision-date' => format_date($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label()]));
    $form_state->setRedirect(
      'entity.risk_assessment.canonical',
       ['risk_assessment' => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {risk_assessment_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.risk_assessment.version_history',
         ['risk_assessment' => $this->revision->id()]
      );
    }
  }

}
