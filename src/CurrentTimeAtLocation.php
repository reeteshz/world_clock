<?php

namespace  Drupal\world_clock;

/**
* @file providing the service that provides times based on location.
*
*/

use Drupal\Component\Datetime\Time;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Config\ConfigFactory;

class CurrentTimeAtLocation {

 protected $time;
 protected $dateFormatter;
 protected $configFactory;

 public function __construct(Time $time, DateFormatter $dateFormatter, ConfigFactory $configFactory) {
   $this->time = $time;
   $this->dateFormatter = $dateFormatter;
   $this->configFactory =  $configFactory;
 }

 public function getCurrentTime(){
    $config = $this->configFactory->get('clock_configuration.settings');
    $current_time = $this->time->getRequestTime();
    return $this->dateFormatter->format($current_time, 'custom', 'dS M Y - h:i A', $timezone = $config->get('timezone'), $langcode = NULL);
 }

}