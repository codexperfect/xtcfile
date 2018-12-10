<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\Core\Serialization\Yaml as YamlSerializer;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "yaml",
 *   label = @Translation("YAML File for XTC"),
 *   description = @Translation("YAML File for XTC description.")
 * )
 */
class Yaml extends File
{

  public function get(){
    $this->buildPath();
    if(file_exists($this->options['path'])){
      $this->content = YamlSerializer::decode(file_get_contents($this->options['path']));

    }
    return $this->content;
  }

}
