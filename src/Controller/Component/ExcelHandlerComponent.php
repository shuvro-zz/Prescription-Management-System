<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Routing\Router;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\ORM\TableRegistry;

//require_once(ROOT . DS . 'vendor' . DS. 'PhpSpreadsheet-develop' .DS. 'samples' .DS. 'Header.php');

class ExcelHandlerComponent extends Component
{
    public $components = ['Common'];

    public function initialize(array $config = [])
    {
        parent::initialize($config);

        $this->controller = $this->_registry->getController();

    }

    function readExcel($inputFileName){
        $spreadsheet = IOFactory::load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        pr($sheetData);die;
    }
}