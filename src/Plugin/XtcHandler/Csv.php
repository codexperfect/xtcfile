<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\xtcfile\API\LoadCsv;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "csv",
 *   label = @Translation("CSV File for XTC"),
 *   description = @Translation("CSV File for XTC description.")
 * )
 */
class Csv extends File {


  public function get(){
    $this->buildPath();
    if(file_exists($this->options['path'])){
      $this->content = file_get_contents($this->options['path']);
      $csv = New LoadCsv();
      $this->content = $csv->getCsvContent($this->content);
    }
    return $this->content;
  }

}
