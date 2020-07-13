<?php

namespace Drupal\risk_register\Form;

use Drupal\child_entity\Context\ChildEntityRouteContextTrait;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Risk revision.
 *
 * @ingroup risk_register
 */
class RiskRegisterRiskRevisionDeleteForm extends ConfirmFormBase {

  use ChildEntityRouteContextTrait;

  /**
   * The Risk revision.
   *
   * @var \Drupal\risk_register\Entity\RiskRegisterRiskInterface
   */
  protected $revision;

  /**
   * The Risk storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $riskRegisterRiskStorage;

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
    $instance->riskRegisterRiskStorage = $container->get('entity_type.manager')->getStorage('risk_register_risk');
    $instance->connection = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'risk_register_risk_revision_delete_confirm';
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
    return new Url('entity.risk_register_risk.version_history', ['risk_register_risk' => $this->revision->id()]);
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
  public function buildForm(array $form, FormStateInterface $form_state, $risk_register_risk_revision = NULL) {
    $this->revision = $this->RiskRegisterRiskStorage->loadRevision($risk_register_risk_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->RiskRegisterRiskStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('Risk: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()]);
    $this->messenger()->addMessage(t('Revision from %revision-date of Risk %title has been deleted.', ['%revision-date' => format_date($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label()]));
    $form_state->setRedirect(
      'entity.risk_register_risk.canonical',
       [
         'risk_register' => $this->getParentEntityFromRoute()->id(),
         'risk_register_risk' => $this->revision->id(),
       ]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {risk_register_risk_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.risk_register_risk.version_history',
         ['risk_register_risk' => $this->revision->id()]
      );
    }
  }

}
