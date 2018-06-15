<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:21
 */

namespace Drupal\xtcfile\XtendedContent\Serve\XtcRequest;


use Drupal\xtc\XtendedContent\Serve\Client\FileClient;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;

class FileXtcRequest extends AbstractXtcRequest
{
  protected function buildClient(){
    if(isset($this->profile)){
      $this->client = new FileClient($this->profile);
    }
    $this->client->setXtcConfigFromYaml();
    return $this;
  }
}
