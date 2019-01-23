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

class XtcDocsController extends ControllerBase
{

  /**
   * @param $module
   *
   * @return array
   */
  public function get($module){
    $values = Config::getDocs($module);
    return [
      '#theme' => 'xtc_mkdocs',
      '#response' => $values,
    ];
  }

  /**
   * @return string
   */
  public function getTitle() {
    return 'Documentation for ' . $this->getModuleName();
  }

  /**
   * @return string
   */
  protected function getModuleName(){
    $machinename = \Drupal::request()->get('module');
    return \Drupal::moduleHandler()->getName($machinename);
  }

}
