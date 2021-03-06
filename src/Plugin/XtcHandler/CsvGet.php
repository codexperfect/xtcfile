<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\xtcfile\API\LoadCsv;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "csv_get",
 *   label = @Translation("CSV File for XTC"),
 *   description = @Translation("CSV File for XTC description.")
 * )
 */
class CsvGet extends FileBase
{

  protected function processContent(){
    $csv = New LoadCsv();
    $this->content = $csv->getContent($this->content);
  }


}
