<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 20/08/2018
 * Time: 16:37
 */

namespace Drupal\xtcfile\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\xtc\XtendedContent\API\Config;

class XtcFileController extends ControllerBase
{

  /**
   * @param $alias
   *
   * @return array
   */
  public function file($alias) {
    $values['body'] = '';
    $handler = Config::getProfile($alias);
    if(!empty($handler)){
      $values['body'] = $handler->get();
    }
    return [
      '#theme' => 'xtc_file',
      '#response' => $values,
    ];
  }

  public function getTitle() {
    return 'File';
  }

  protected function getType() {
    return 'file';
  }

}
