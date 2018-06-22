<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:51
 */

namespace Drupal\xtcfile\XtendedContent\Serve\Client;


use Drupal\Component\Serialization\Json;
use Drupal\Component\Serialization\Yaml;
use Drupal\xtcfile\API\Csv;

class FileClient extends AbstractFileClient
{
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


}