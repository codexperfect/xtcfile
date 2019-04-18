<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\Core\Serialization\Yaml as YamlSerializer;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "yaml_get",
 *   label = @Translation("YAML File for XTC"),
 *   description = @Translation("YAML File for XTC description.")
 * )
 */
class Yaml extends FileBase
{

  protected function processContent(){
    $this->content = YamlSerializer::decode($this->content);
  }

}
