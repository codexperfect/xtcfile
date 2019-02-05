<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 20/08/2018
 * Time: 16:37
 */

namespace Drupal\xtcfile\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\xtc\XtendedContent\API\Config;
use Drupal\xtc\XtendedContent\API\Documentation;

class XtcDocsPageController extends ControllerBase
{

  /**
   * @param $module
   * @param $id
   *
   * @return array
   */
  public function get($module, $id){
    $path = explode('-',$id);
    if(count($path) == 1){
      $values['parent'] = Url::fromRoute('xtcfile.docs.docs', ['module'
      => $module])->toString();
    }
    else {
      $up = $path;
      unset($up[count($path)-1]);
      $values['parent'] = implode('-', $up);
    }

    $item = $this->getItem($this->getIndex($module), $path);
    $values['title'] = key($item);
    $values['path'] = $id;
    $current = current($item);
    if(is_array($current)){
      $values['content'] = '';
      $values['subpages'] = $current;
    }
    else{
      $values['content'] = Documentation::getDocsPage($module, $current);
    }
    return [
      '#theme' => 'xtc_mkdocs_page',
      '#response' => $values,
    ];
  }

  /**
   * @param $module
   *
   * @return array
   */
  protected function getIndex($module){
    return Documentation::getDocs($module)['pages'];
  }

  /**
   * @param     $index
   * @param     $path
   * @param int $level
   *
   * @return mixed
   */
  protected function getItem($index, $path, $level = 0){
    $id = intval($path[$level]);
    $item = $index[$id];
    $next = $level+1;
    if($next+1 < count($path)){
      $item = $this->getItem(current($item), $path, $next);
    }
    return $item;
  }

  /**
   * @return string
   */
  public function getTitle() {
    $request = \Drupal::request();
    $name = \Drupal::moduleHandler()->getName($request->get('module'));
    return $this->getPageTitle($request->get('module'), $request->get('id'))
           . $this->t(' - Documentation for :name', [':name' => $name]);
  }

  /**
   * @param $module
   * @param $id
   *
   * @return int|null|string
   */
  protected function getPageTitle($module, $id){
    $path = explode('-', $id);
    $item = $this->getItem($this->getIndex($module), $path);
    return key($item);
  }

}
