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

class AbstractFileXtcRequest extends AbstractXtcRequest
{
  protected function buildClient(){
    $this->client = $this->getFileClient();
    $this->client->setXtcConfig($this->config);
    return $this;
  }

  protected function getFileClient(){
    return New FileClient($this->profile);
  }

}
