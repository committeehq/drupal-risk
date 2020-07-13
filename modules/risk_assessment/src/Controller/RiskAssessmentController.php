<?php

namespace Drupal\risk_assessment\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\risk_assessment\Entity\RiskAssessmentInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RiskAssessmentController.
 *
 *  Returns responses for Risk assessment routes.
 */
class RiskAssessmentController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Risk assessment revision.
   *
   * @param int $risk_assessment_revision
   *   The Risk assessment revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($risk_assessment_revision) {
    $risk_assessment = $this->entityTypeManager()->getStorage('risk_assessment')
      ->loadRevision($risk_assessment_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('risk_assessment');

    return $view_builder->view($risk_assessment);
  }

  /**
   * Page title callback for a Risk assessment revision.
   *
   * @param int $risk_assessment_revision
   *   The Risk assessment revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($risk_assessment_revision) {
    $risk_assessment = $this->entityTypeManager()->getStorage('risk_assessment')
      ->loadRevision($risk_assessment_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $risk_assessment->label(),
      '%date' => $this->dateFormatter->format($risk_assessment->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Risk assessment.
   *
   * @param \Drupal\risk_assessment\Entity\RiskAssessmentInterface $risk_assessment
   *   A Risk assessment object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(RiskAssessmentInterface $risk_assessment) {
    $account = $this->currentUser();
    $risk_assessment_storage = $this->entityTypeManager()->getStorage('risk_assessment');

    $langcode = $risk_assessment->language()->getId();
    $langname = $risk_assessment->language()->getName();
    $languages = $risk_assessment->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $risk_assessment->label()]) : $this->t('Revisions for %title', ['%title' => $risk_assessment->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all risk assessment revisions") || $account->hasPermission('administer risk assessment entities')));
    $delete_permission = (($account->hasPermission("delete all risk assessment revisions") || $account->hasPermission('administer risk assessment entities')));

    $rows = [];

    $vids = $risk_assessment_storage->revisionIds($risk_assessment);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\risk_assessment\RiskAssessmentInterface $revision */
      $revision = $risk_assessment_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $risk_assessment->getRevisionId()) {
          $link = $this->l($date, new Url('entity.risk_assessment.revision', [
            'risk_assessment' => $risk_assessment->id(),
            'risk_assessment_revision' => $vid,
          ]));
        }
        else {
          $link = $risk_assessment->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.risk_assessment.translation_revert', [
                'risk_assessment' => $risk_assessment->id(),
                'risk_assessment_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.risk_assessment.revision_revert', [
                'risk_assessment' => $risk_assessment->id(),
                'risk_assessment_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.risk_assessment.revision_delete', [
                'risk_assessment' => $risk_assessment->id(),
                'risk_assessment_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['risk_assessment_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
