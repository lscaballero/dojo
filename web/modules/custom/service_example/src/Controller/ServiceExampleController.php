<?php


namespace Drupal\service_example\Controller;

/**
 * Class ServiceExampleController
 * @package Drupal\service_example\Controller
 */
class ServiceExampleController extends \Drupal\Core\Controller\ControllerBase
{
  /**
   * @return array
   */
  public function  content(): array
  {
    $myservice = \Drupal::service('service_example.saludo');
    $mysalute = $myservice->getSaludo();

    return [
      '#markup' => $this->t('Hello @mysalute', ['@mysalute' => $mysalute])
    ];
  }
}
