<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 20/08/2018
 * Time: 16:37
 */

namespace Drupal\xtcfile\Controller;


use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;

class XtcDocumentationController extends ControllerBase
{

  protected $module;

  public function get() {
    // We are checking permissions, so add the user.permissions cache context.
    $cacheability = new CacheableMetadata();
    $modules = \Drupal::moduleHandler()->getModuleList();
    $output = [
      '#theme' => 'xtc_documentation',
      '#links' => [],
    ];
    foreach($modules as $name => $module){
      $this->module = $name;
      $helpLink = Link::createFromRoute($this->t('Help'), 'help.page',
                                        ['name' => $name])->toString();

      $output['#links'][$name] =[
        '#theme' => 'xtc_docs_links',
        '#name' => \Drupal::moduleHandler()->getName($name),
        '#help' => $helpLink,
        '#docs' => $this->link2Docs(),
        '#readme' => $this->link2Readme(),
        '#empty' => $this->t('There is currently documentation available.'),
      ];
      $cacheability->addCacheableDependency($module);
    }
    $cacheability->applyTo($output);
    return $output;
  }

  public function getHelp(){
    return '<h2>README file</h2><p>View ' . $this->link2Readme() . '.</p>' .
           '<h2>Documentation</h2><p>Read ' . $this->link2Docs() . '.</p>'
      ;
  }

  /**
   * @param $module
   *
   * @return string
   */
  public function link2Readme($text = 'README'){
    $pathMd = file_exists(\Drupal::moduleHandler()
                                 ->getModule($this->module)->getPath() .'/README.md');
    $pathTxt = file_exists(\Drupal::moduleHandler()
                                  ->getModule($this->module)->getPath() .'/README.txt');
    $exist = ($pathTxt || $pathMd);
    if($exist) {
      return Link::createFromRoute($this->t($text), 'xtcfile.docs.readme', [
        'module' => $this->module])->toString();
    }
  }

  /**
   * @param $module
   *
   * @return string
   */
  public function link2Docs($text = 'Documentation'){
    $path = \Drupal::moduleHandler()->getModule($this->module)->getPath() .'/help/mkdocs.yml';
    if(file_exists($path)){
      return Link::createFromRoute($this->t($text), 'xtcfile.docs.docs',
                                   ['module' => $this->module])->toString();
    }
  }
}
