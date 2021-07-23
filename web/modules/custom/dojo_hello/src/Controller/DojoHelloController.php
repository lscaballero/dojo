<?php

/**
 * @file
 * Contains \Drupal\dojo_hello\Controller\DojoHelloController
 */

namespace Drupal\dojo_hello\Controller;

use Drupal\Core\Controller\ControllerBase;

class DojoHelloController extends ControllerBase
{
  public function hello()
  {
    return [
      '#markup' => '<p>' . $this->t('Hello, Dojo') . '</p>'
    ];
  }

}
