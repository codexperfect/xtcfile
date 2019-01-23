<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 20/08/2018
 * Time: 16:37
 */

namespace Drupal\xtcfile\Controller;


use Drupal\xtc\XtendedContent\API\Config;

class XtcReadmeController extends XtcFileController
{

  /**
   * @param $alias
   *
   * @return array
   */
  public function file($module) {
    foreach(['README.md', 'README.txt'] as $path){
      $profile = [
        'type' => 'readme',
        'abs_path' => false,
        'module' => $module,
        'path' => $path,
      ];
      $content = Config::getFromProfile($profile) ?? '';
      if(!empty($content)){
        break;
      }
    }
    if(empty($content)){
      $content = "<h2>README file is empty or needs to be created.</h2>
           <p>Please contact the maintainer of the module.</p>
        ";
    }
    $values['body'] = $content;
    return [
      '#theme' => 'xtc_file',
      '#response' => $values,
    ];
  }

  public function getTitle() {
    return $this->getModuleName() . ' - README file';
  }

  protected function getType() {
    return 'file';
  }

  protected function getModuleName(){
    $machinename = \Drupal::request()->get('module');
    return \Drupal::moduleHandler()->getName($machinename);
  }

}
