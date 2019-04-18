<?php

namespace Drupal\xtcfile\Plugin\XtcHandler;


use Drupal\xtcfile\API\LoadMarkdown;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "markdown_get",
 *   label = @Translation("Markdown File for XTC"),
 *   description = @Translation("Markdown File for XTC description.")
 * )
 */
class MarkdownGet extends FileBase
{

  protected function processContent(){
    $markdown = New LoadMarkdown();
    $this->content = $markdown->getContent($this->content);
  }

}
