<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\xtcfile\API\LoadMarkdown;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "markdown",
 *   label = @Translation("Markdown File for XTC"),
 *   description = @Translation("Markdown File for XTC description.")
 * )
 */
class Markdown extends FileBase
{

  public function get(){
    $this->buildPath();
    if(file_exists($this->options['path'])){
      $content = file_get_contents($this->options['path']);
      $markdown = New LoadMarkdown();
      $this->content = $markdown->getContent($content);
    }
    return $this->content;
  }

}
