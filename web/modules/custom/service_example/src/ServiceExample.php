<?php

namespace Drupal\service_example;


/**
 * Class ServiceExample
 * @package Drupal\service_example
 * @file
 * Service Example
 */

class ServiceExample
{
 private $saludo;

  /**
   * ServiceExample constructor.
   */
 public function __construct()
 {
   $this->saludo = ['Hol', 'senor locutor', 'quiero'];
 }

  /**
   * @return string
   */
  public function getSaludo(): string
  {
    return $this->saludo[array_rand($this->saludo)];
  }
}
