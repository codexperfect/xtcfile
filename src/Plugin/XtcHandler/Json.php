<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\Component\Serialization\Json as JsonSerializer;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "json",
 *   label = @Translation("JSON File for XTC"),
 *   description = @Translation("JSON File for XTC description.")
 * )
 */
class Json extends FileBase
{

  protected function processContent(){
    $this->content = JsonSerializer::decode($this->content);
  }

}
