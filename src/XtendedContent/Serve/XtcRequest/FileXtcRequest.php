<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:21
 */

namespace Drupal\xtcfile\XtendedContent\Serve\XtcRequest;


use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;
use Drupal\xtcfile\XtendedContent\Serve\Client\FileClient;

class FileXtcRequest extends AbstractXtcRequest
{
  protected function buildClient(){
    if(isset($this->profile)){
      $this->client = new FileClient($this->profile);
    }
    $this->client->setXtcConfigFromYaml();
    return $this;
  }

  protected function buildClientFromConfig($config){
    if(isset($this->profile)){
      $this->client = new FileClient($this->profile);
    }
    $this->client->setXtcConfig($config);
    return $this;
  }
}
