<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\Core\Serialization\Yaml;
use Drupal\xtcfile\API\LoadMarkdown;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "mkdocs_get",
 *   label = @Translation("MkDocs File for XTC"),
 *   description = @Translation("MkDocs File for XTC description.")
 * )
 */
class MkDocsGet extends FileBase
{

  protected function processContent(){
    if ('mkdocs.yml' == basename($this->profile['path'])){
      $this->content = Yaml::decode($this->content);
    }
    else{
      $markdown = New LoadMarkdown();
      $this->content = $markdown->getContent($this->content);
    }
  }

}
