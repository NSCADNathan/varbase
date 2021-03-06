<?php

namespace Drupal\update_helper\Command;

use Drush\Commands\DrushCommands;
use Drupal\update_helper\Utility\CommandHelper;
use Psr\Log\LoggerInterface;

/**
 * Class ApplyConfigurationUpdateCommand.
 *
 * Define drush commands for update_helper module.
 *
 * @package Drupal\update_helper\Command
 */
class ApplyConfigurationUpdateCommands extends DrushCommands {

  /**
   * Command helper object (inspired by search API module)
   *
   * @var \Drupal\update_helper\Utility\CommandHelper
   */
  protected $commandHelper;

  /**
   * ApplyConfigurationUpdateCommands constructor.
   */
  public function __construct() {
    $this->commandHelper = new CommandHelper();
  }

  /**
   * {@inheritdoc}
   */
  public function setLogger(LoggerInterface $logger) {
    parent::setLogger($logger);
    $this->commandHelper->setLogger($logger);
  }

  /**
   * Applying an update hook (function) from module install file.
   *
   * Apply updates by invoking the related update hooks.
   *
   * @param string $module
   *   The module.
   * @param string $update_hook
   *   The update hook.
   * @param array $options
   *   The options array.
   *
   * @option force
   *
   * @command update_helper:apply-update
   * @aliases uhau
   */
  public function applyUpdate($module = '', $update_hook = '', array $options = ['force' => FALSE]) {
    $force = $options['force'];
    $this->commandHelper->applyUpdate($module, $update_hook, $force);
  }

}
