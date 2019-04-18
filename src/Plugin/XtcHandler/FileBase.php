<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;

/**
 * Plugin implementation of the xtc_handler for File.
 *
 */
abstract class FileBase extends XtcHandlerPluginBase
{

  public function process(){
    $this->buildPath();
    if(file_exists($this->options['path'])){
      $this->content = file_get_contents($this->options['path']);
      $this->processContent();
    }
    return $this;
  }

  protected function processContent(){
  }

  public function setOptions($options = []) : XtcHandlerPluginBase{
    $options['path'] = $this->buildPath();
    $this->options = $options;
    return $this;
  }

  protected function buildPath(){
    if($this->profile['abs_path']){
      return $this->profile['path'];
    }
    else{
      $module_handler = \Drupal::service('module_handler');
      // TODO: Provide a container to test class to make it not fail here.
      $pwd = $module_handler->getModule($this->profile['module'])->getPath();
      return $pwd.'/'.$this->profile['path'];
    }
  }
}
