<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 11:01
 */

namespace Drupal\xtcfile\XtendedContent\Serve\Client;


use Drupal\Component\Serialization\Json;
use Drupal\xtc\XtendedContent\Serve\Client\AbstractClient;
use Drupal\xtc\XtendedContent\Serve\Client\ClientInterface;

class AbstractFileClient extends AbstractClient
{

  /**
   * @var string
   */
  protected $method;

  /**
   * @var string
   */
  protected $param;

  /**
   * @var string
   */
  protected $content;

  /**
   * @return string
   */
  public function get() : string {
    if(method_exists($this, $this->method)){
      $getMethod = $this->method;
      $this->${"getMethod"}();
    }
    return Json::encode($this->content);
  }

  /**
   * @param string $method
   * @param string $param
   *
   * @return ClientInterface
   */
  public function init($method, $param = '') : ClientInterface{
    $this->method = $method;
    $this->param = $param;
    return $this;
  }

  protected function getContent(){
    if(file_exists($this->options['path'])){
      $content = file_get_contents($this->options['path']);
    }
    return (isset($content)) ? $content : '';
  }

  /**
   * @return ClientInterface
   */
  public function setOptions()  : ClientInterface {
    $this->setClientProfile();
    $options['path'] = $this->buildPath();
    $this->options = $options;
    return $this;
  }

  private function buildPath(){
    if($this->getInfo('abs_path')){
      return $this->getInfo('path');
    }
    else{
      $module_handler = \Drupal::service('module_handler');
      // TODO: Provide a container to test class to make it not fail here.
      $pwd = $module_handler->getModule($this->getInfo('module'))->getPath();
      return $pwd.'/'.$this->getInfo('path');
    }
  }

}
