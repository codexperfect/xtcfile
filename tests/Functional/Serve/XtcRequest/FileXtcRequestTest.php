<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/05/2018
 * Time: 16:34
 */


namespace Drupal\Tests\csoec_user\Functional\Serve\XtcRequest;

//include_once __DIR__.'/../../../../../../extranet/csoec_extranet/vendor/autoload.php';

use Drupal\Tests\UnitTestCase;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\XtcRequestInterface;
use Drupal\xtcfile\XtendedContent\Serve\XtcRequest\FileXtcRequest;

class FileXtcRequestTest extends UnitTestCase
{
  /**
   * @var XtcRequestInterface
   */
  protected $xtcRequest;

  private const ALLOWED = [
    "allowed" => [
      0 => "getDummyData",
      1 => "getCsvData",
      2 => "getTxtData",
      3 => "getYamlData",
      4 => "getJsonData",
    ],
  ];

  protected function setUp() {
    parent::setUp();
  }

  public function testPerformAllRequest(){
    $config = $this->setXtcConfig()['xtcontent']['serve_xtcrequest'];
    foreach ($config as $name => $conf){
      $this->performOneRequest($name);
    }
  }

  private function performOneRequest($name){
    $config = $this->setClientConfig()['xtcontent']['serve_client'][$name];
    $format = $config['format'];
    $method = 'get'. ucfirst($format) .'Data';

    $xtcRequest = New FileXtcRequest($name);
    $xtcRequest->setConfig($this->setXtcConfig());
    $xtcRequest->getClient()->setXtcConfig($this->setClientConfig());
    $this->xtcRequest = $xtcRequest;

    $this->xtcRequest->get($method);
    $response = $this->xtcRequest->getData();
    $expected = $this->expected($name);
    $this->assertSame($expected, $response);
  }

  private function setXtcConfig(){
    return [
      "xtcontent" => [
        "serve_xtcrequest" => [
          "test_text" => $this::ALLOWED,
          "test_html" => $this::ALLOWED,
          "test_csv" => $this::ALLOWED,
          "test_yaml" => $this::ALLOWED,
          "test_json" => $this::ALLOWED,
        ],
      ],
    ];
  }
  private function setClientConfig(){
    return [
      "xtcontent" => [
        "serve_client" => [
          "test_text" => [
            "type" => "file",
            "format" => "txt",
            "abs_path" => false,
            "module" => "xtcfile",
            "path" => "example/demo.txt",
          ],
          "test_html" => [
            "type" => "file",
            "format" => "txt",
            "abs_path" => false,
            "module" => "xtcfile",
            "path" => "example/demo.html",
          ],
          "test_csv" => [
            "type" => "file",
            "format" => "csv",
            "abs_path" => false,
            "module" => "xtcfile",
            "path" => "example/demo.csv",
          ],
          "test_yaml" => [
            "type" => "file",
            "format" => "yaml",
            "abs_path" => false,
            "module" => "xtcfile",
            "path" => "example/demo.yaml",
          ],
          "test_json" => [
            "type" => "file",
            "format" => "json",
            "abs_path" => false,
            "module" => "xtcfile",
            "path" => "example/demo.json",
          ],
        ],
      ],
    ];
  }

  private function expected($name){
    switch ($name){
      case 'test_text':
        return '"\u003Ch3\u003ELorem demo text\u003C\/h3\u003E\n\n\u003Cp\u003ELorem ipsum dolor sit amet, consectetur adipiscing elit. Sed odio risus, volutpat non scelerisque a, convallis quis metus. Morbi velit dolor, facilisis a lorem nec, fermentum dignissim magna. Etiam tristique risus in lorem ornare, quis congue nisl faucibus. Ut faucibus nisl a odio blandit, at aliquam nisl imperdiet. Donec ut tincidunt mi. Aliquam porta tempor fermentum. Pellentesque in volutpat diam, lobortis finibus est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse lobortis lectus vel nunc gravida, in tempor est aliquet. Phasellus sagittis convallis felis, sit amet bibendum est malesuada sed. Sed quis lorem eu metus maximus elementum tempus a odio. Pellentesque urna tellus, hendrerit et quam a, varius egestas ipsum. Phasellus nec vehicula orci. Aliquam dolor lectus, dictum nec mollis a, egestas a purus.\u003C\/p\u003E\n\u003Cp\u003EQuisque neque felis, consequat id vestibulum sodales, tincidunt vel quam. Curabitur justo augue, efficitur ut quam sed, egestas blandit tellus. Morbi facilisis condimentum dui at sagittis. Integer suscipit viverra eros, et feugiat mauris lobortis sed. Aliquam molestie metus vel dolor placerat, eu mattis odio finibus. Vivamus eu purus quis nulla porttitor iaculis sed non massa. Curabitur quis arcu ut nunc feugiat imperdiet nec suscipit ligula. Proin malesuada ullamcorper sapien et pulvinar.\u003C\/p\u003E\n\u003Cp\u003EInteger ipsum mauris, rutrum eu ante sed, semper sodales nunc. Vestibulum ut condimentum tortor. Curabitur congue id arcu nec consectetur. Praesent pharetra purus suscipit lectus imperdiet laoreet. Nulla convallis maximus risus. Nulla semper nisi non aliquet pharetra. Nam fringilla vulputate tellus, fringilla commodo dolor aliquet vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras ut felis tincidunt, tempor justo sed, imperdiet mauris. Sed hendrerit sed ex scelerisque luctus. Nam eget cursus sapien, ut venenatis risus. Vivamus eu purus ipsum. Quisque consectetur velit urna, sed vulputate sapien dignissim ac. Phasellus vel diam vitae felis sodales convallis.\u003C\/p\u003E\n"';
        break;
      case 'test_html':
        return '"\u003Ch3\u003ELorem demo text\u003C\/h3\u003E\n\n\u003Cp\u003ELorem ipsum dolor sit amet, consectetur adipiscing elit. Sed odio risus, volutpat non scelerisque a, convallis quis metus. Morbi velit dolor, facilisis a lorem nec, fermentum dignissim magna. Etiam tristique risus in lorem ornare, quis congue nisl faucibus. Ut faucibus nisl a odio blandit, at aliquam nisl imperdiet. Donec ut tincidunt mi. Aliquam porta tempor fermentum. Pellentesque in volutpat diam, lobortis finibus est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse lobortis lectus vel nunc gravida, in tempor est aliquet. Phasellus sagittis convallis felis, sit amet bibendum est malesuada sed. Sed quis lorem eu metus maximus elementum tempus a odio. Pellentesque urna tellus, hendrerit et quam a, varius egestas ipsum. Phasellus nec vehicula orci. Aliquam dolor lectus, dictum nec mollis a, egestas a purus.\u003C\/p\u003E\n\u003Cp\u003EQuisque neque felis, consequat id vestibulum sodales, tincidunt vel quam. Curabitur justo augue, efficitur ut quam sed, egestas blandit tellus. Morbi facilisis condimentum dui at sagittis. Integer suscipit viverra eros, et feugiat mauris lobortis sed. Aliquam molestie metus vel dolor placerat, eu mattis odio finibus. Vivamus eu purus quis nulla porttitor iaculis sed non massa. Curabitur quis arcu ut nunc feugiat imperdiet nec suscipit ligula. Proin malesuada ullamcorper sapien et pulvinar.\u003C\/p\u003E\n\u003Cp\u003EInteger ipsum mauris, rutrum eu ante sed, semper sodales nunc. Vestibulum ut condimentum tortor. Curabitur congue id arcu nec consectetur. Praesent pharetra purus suscipit lectus imperdiet laoreet. Nulla convallis maximus risus. Nulla semper nisi non aliquet pharetra. Nam fringilla vulputate tellus, fringilla commodo dolor aliquet vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras ut felis tincidunt, tempor justo sed, imperdiet mauris. Sed hendrerit sed ex scelerisque luctus. Nam eget cursus sapien, ut venenatis risus. Vivamus eu purus ipsum. Quisque consectetur velit urna, sed vulputate sapien dignissim ac. Phasellus vel diam vitae felis sodales convallis.\u003C\/p\u003E\n"';
        break;
      case 'test_csv':
        return '{"titles":["tag","text"],"rows":[{"tag":"h3","text":"Lorem demo text"},{"tag":"p","text":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed odio risus, volutpat non scelerisque a, convallis quis metus. Morbi velit dolor, facilisis a lorem nec, fermentum dignissim magna. Etiam tristique risus in lorem ornare, quis congue nisl faucibus. Ut faucibus nisl a odio blandit, at aliquam nisl imperdiet. Donec ut tincidunt mi. Aliquam porta tempor fermentum. Pellentesque in volutpat diam, lobortis finibus est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse lobortis lectus vel nunc gravida, in tempor est aliquet. Phasellus sagittis convallis felis, sit amet bibendum est malesuada sed. Sed quis lorem eu metus maximus elementum tempus a odio. Pellentesque urna tellus, hendrerit et quam a, varius egestas ipsum. Phasellus nec vehicula orci. Aliquam dolor lectus, dictum nec mollis a, egestas a purus."},{"tag":"p","text":"Quisque neque felis, consequat id vestibulum sodales, tincidunt vel quam. Curabitur justo augue, efficitur ut quam sed, egestas blandit tellus. Morbi facilisis condimentum dui at sagittis. Integer suscipit viverra eros, et feugiat mauris lobortis sed. Aliquam molestie metus vel dolor placerat, eu mattis odio finibus. Vivamus eu purus quis nulla porttitor iaculis sed non massa. Curabitur quis arcu ut nunc feugiat imperdiet nec suscipit ligula. Proin malesuada ullamcorper sapien et pulvinar."},{"tag":"p","text":"Integer ipsum mauris, rutrum eu ante sed, semper sodales nunc. Vestibulum ut condimentum tortor. Curabitur congue id arcu nec consectetur. Praesent pharetra purus suscipit lectus imperdiet laoreet. Nulla convallis maximus risus. Nulla semper nisi non aliquet pharetra. Nam fringilla vulputate tellus, fringilla commodo dolor aliquet vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras ut felis tincidunt, tempor justo sed, imperdiet mauris. Sed hendrerit sed ex scelerisque luctus. Nam eget cursus sapien, ut venenatis risus. Vivamus eu purus ipsum. Quisque consectetur velit urna, sed vulputate sapien dignissim ac. Phasellus vel diam vitae felis sodales convallis."}]}';
        break;
      case 'test_yaml':
        return '{"h3":"Lorem demo text","p":["Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed odio risus, volutpat non scelerisque a, convallis quis metus. Morbi velit dolor, facilisis a lorem nec, fermentum dignissim magna. Etiam tristique risus in lorem ornare, quis congue nisl faucibus. Ut faucibus nisl a odio blandit, at aliquam nisl imperdiet. Donec ut tincidunt mi. Aliquam porta tempor fermentum. Pellentesque in volutpat diam, lobortis finibus est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse lobortis lectus vel nunc gravida, in tempor est aliquet. Phasellus sagittis convallis felis, sit amet bibendum est malesuada sed. Sed quis lorem eu metus maximus elementum tempus a odio. Pellentesque urna tellus, hendrerit et quam a, varius egestas ipsum. Phasellus nec vehicula orci. Aliquam dolor lectus, dictum nec mollis a, egestas a purus.","Quisque neque felis, consequat id vestibulum sodales, tincidunt vel quam. Curabitur justo augue, efficitur ut quam sed, egestas blandit tellus. Morbi facilisis condimentum dui at sagittis. Integer suscipit viverra eros, et feugiat mauris lobortis sed. Aliquam molestie metus vel dolor placerat, eu mattis odio finibus. Vivamus eu purus quis nulla porttitor iaculis sed non massa. Curabitur quis arcu ut nunc feugiat imperdiet nec suscipit ligula. Proin malesuada ullamcorper sapien et pulvinar.","Integer ipsum mauris, rutrum eu ante sed, semper sodales nunc. Vestibulum ut condimentum tortor. Curabitur congue id arcu nec consectetur. Praesent pharetra purus suscipit lectus imperdiet laoreet. Nulla convallis maximus risus. Nulla semper nisi non aliquet pharetra. Nam fringilla vulputate tellus, fringilla commodo dolor aliquet vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras ut felis tincidunt, tempor justo sed, imperdiet mauris. Sed hendrerit sed ex scelerisque luctus. Nam eget cursus sapien, ut venenatis risus. Vivamus eu purus ipsum. Quisque consectetur velit urna, sed vulputate sapien dignissim ac. Phasellus vel diam vitae felis sodales convallis."]}';
        break;
      case 'test_json':
        return '{"h3":"Lorem demo text","p":["Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed odio risus, volutpat non scelerisque a, convallis quis metus. Morbi velit dolor, facilisis a lorem nec, fermentum dignissim magna. Etiam tristique risus in lorem ornare, quis congue nisl faucibus. Ut faucibus nisl a odio blandit, at aliquam nisl imperdiet. Donec ut tincidunt mi. Aliquam porta tempor fermentum. Pellentesque in volutpat diam, lobortis finibus est. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse lobortis lectus vel nunc gravida, in tempor est aliquet. Phasellus sagittis convallis felis, sit amet bibendum est malesuada sed. Sed quis lorem eu metus maximus elementum tempus a odio. Pellentesque urna tellus, hendrerit et quam a, varius egestas ipsum. Phasellus nec vehicula orci. Aliquam dolor lectus, dictum nec mollis a, egestas a purus.","Quisque neque felis, consequat id vestibulum sodales, tincidunt vel quam. Curabitur justo augue, efficitur ut quam sed, egestas blandit tellus. Morbi facilisis condimentum dui at sagittis. Integer suscipit viverra eros, et feugiat mauris lobortis sed. Aliquam molestie metus vel dolor placerat, eu mattis odio finibus. Vivamus eu purus quis nulla porttitor iaculis sed non massa. Curabitur quis arcu ut nunc feugiat imperdiet nec suscipit ligula. Proin malesuada ullamcorper sapien et pulvinar.","Integer ipsum mauris, rutrum eu ante sed, semper sodales nunc. Vestibulum ut condimentum tortor. Curabitur congue id arcu nec consectetur. Praesent pharetra purus suscipit lectus imperdiet laoreet. Nulla convallis maximus risus. Nulla semper nisi non aliquet pharetra. Nam fringilla vulputate tellus, fringilla commodo dolor aliquet vitae. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Cras ut felis tincidunt, tempor justo sed, imperdiet mauris. Sed hendrerit sed ex scelerisque luctus. Nam eget cursus sapien, ut venenatis risus. Vivamus eu purus ipsum. Quisque consectetur velit urna, sed vulputate sapien dignissim ac. Phasellus vel diam vitae felis sodales convallis."]}';
        break;
    }
  }
}
