<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 11:01
 */

namespace Drupal\xtcfile\XtendedContent\Serve\Client;


use Drupal\Component\Serialization\Json;
use Drupal\Core\Serialization\Yaml;
use Drupal\xtc\XtendedContent\Serve\Client\AbstractClient;
use Drupal\xtc\XtendedContent\Serve\Client\ClientInterface;
use Drupal\xtcfile\API\Csv;

class FileClient extends AbstractClient
{

  /**
   * @var string
   */
  private $method;

  /**
   * @var string
   */
  private $param;

  /**
   * @var string
   */
  private $content;

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

  public function getDummyData(){
    switch ($this->getInfo('format')){
      case 'csv':
        $this->getCsvData();
        break;
      case 'txt':
        $this->getTxtData();
        break;
      case 'yaml':
        $this->getYamlData();
        break;
      case 'json':
        $this->getJsonData();
        break;
      default:
        $this->content =  '';
    }
    return $this;
  }

  private function getContent(){
    if(file_exists($this->options['path'])){
      $content = file_get_contents($this->options['path']);
    }
    return (isset($content)) ? $content : '';
  }

  public function getCsvData(){
    $csv = New Csv();
    $this->content = $csv->getCsvContent($this->getContent());
    return $this;
  }

  public function getTxtData(){
    $this->content = $this->getContent();
    return $this;
  }

  public function getYamlData(){
    $this->content = Yaml::decode($this->getContent());
    return $this;
  }

  public function getJsonData(){
    $this->content = Json::decode($this->getContent());
    return $this;
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
