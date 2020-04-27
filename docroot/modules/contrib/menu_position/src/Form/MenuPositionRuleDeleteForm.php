<?php

namespace Drupal\menu_position\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Menu\MenuLinkManagerInterface;
use Drupal\Core\ProxyClass\Routing\RouteBuilder;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds the form to delete a Example.
 */

class MenuPositionRuleDeleteForm extends EntityConfirmFormBase {

  /**
   * The Menu Parent Form Selector.
   *
   * @var \Drupal\Core\Menu\MenuLinkManagerInterface
   */
  protected $menu_link_manager;

  /**
   * The Route Builder.
   *
   * @var \Drupal\Core\ProxyClass\Routing\RouteBuilder
   */
  protected $route_builder;

  /**
   * The menu position rule delete form constructor.
   *
   * @param \Drupal\Core\Menu\MenuLinkManagerInterface $menu_link_manager
   *   The menu link manager.
   * @param \Drupal\Core\ProxyClass\Routing\RouteBuilder $route_builder
   *   The route builder.
   */
  public function __construct(
    MenuLinkManagerInterface $menu_link_manager,
    RouteBuilder $route_builder) {

    $this->menu_link_manager = $menu_link_manager;
    $this->route_builder = $route_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.menu.link'),
      $container->get('router.builder')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the %name rule?', ['%name' => $this->entity->label()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.menu_position_rule.order_form');
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
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->menu_link_manager->removeDefinition($this->entity->getMenuLink());
    $this->entity->delete();
    drupal_set_message($this->t('The %label rule has been deleted.', ['%label' => $this->entity->getLabel()]));

    // Flush appropriate menu cache.
    $this->route_builder->rebuild();

    $form_state->setRedirectUrl($this->getCancelUrl());
  }
}
