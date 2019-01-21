<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-21
 * Time: 09:39
 */

namespace Drupal\xtcfile\API;


class LoadMarkdown
{

  public function getContent($content){
    $parsedown = New Parsedown();
    return $parsedown->text($content);
  }

}