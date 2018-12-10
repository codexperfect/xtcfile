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
class Json extends File
{

  public function get(){
    $this->buildPath();
    if(file_exists($this->options['path'])){
      $this->content = JsonSerializer::decode(file_get_contents($this->options['path']));
    }
    return $this->content;
  }

}
