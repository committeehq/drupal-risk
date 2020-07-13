<?php

namespace Drupal\risk_register\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\risk_register\Entity\RiskRegisterRiskInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RiskRegisterRiskController.
 *
 *  Returns responses for Risk routes.
 */
class RiskRegisterRiskController extends ControllerBase implements ContainerInjectionInterface {

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
   * Displays a Risk revision.
   *
   * @param int $risk_register_risk_revision
   *   The Risk revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($risk_register_risk_revision) {
    $risk_register_risk = $this->entityTypeManager()->getStorage('risk_register_risk')
      ->loadRevision($risk_register_risk_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('risk_register_risk');

    return $view_builder->view($risk_register_risk);
  }

  /**
   * Page title callback for a Risk revision.
   *
   * @param int $risk_register_risk_revision
   *   The Risk revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($risk_register_risk_revision) {
    $risk_register_risk = $this->entityTypeManager()->getStorage('risk_register_risk')
      ->loadRevision($risk_register_risk_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $risk_register_risk->label(),
      '%date' => $this->dateFormatter->format($risk_register_risk->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Risk.
   *
   * @param \Drupal\risk_register\Entity\RiskRegisterRiskInterface $risk_register_risk
   *   A Risk object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(RiskRegisterRiskInterface $risk_register_risk) {
    $account = $this->currentUser();
    $risk_register_risk_storage = $this->entityTypeManager()->getStorage('risk_register_risk');

    $build['#title'] = $this->t('Revisions for %title', ['%title' => $risk_register_risk->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all risk revisions") || $account->hasPermission('administer risk entities')));
    $delete_permission = (($account->hasPermission("delete all risk revisions") || $account->hasPermission('administer risk entities')));

    $rows = [];

    $vids = $risk_register_risk_storage->revisionIds($risk_register_risk);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\risk_register\RiskRegisterRiskInterface $revision */
      $revision = $risk_register_risk_storage->loadRevision($vid);
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $risk_register_risk->getRevisionId()) {
          $link = $this->l($date, new Url('entity.risk_register_risk.revision', [
            'risk_register_risk' => $risk_register_risk->id(),
            'risk_register_risk_revision' => $vid,
          ]));
        }
        else {
          $link = $risk_register_risk->link($date);
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
              'url' => Url::fromRoute('entity.risk_register_risk.revision_revert', [
                'risk_register_risk' => $risk_register_risk->id(),
                'risk_register_risk_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.risk_register_risk.revision_delete', [
                'risk_register_risk' => $risk_register_risk->id(),
                'risk_register_risk_revision' => $vid,
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

    $build['risk_register_risk_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
