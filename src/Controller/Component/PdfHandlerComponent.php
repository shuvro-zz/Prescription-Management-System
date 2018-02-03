<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Routing\Router;
use TCPDF;
use Cake\ORM\TableRegistry;

require_once(ROOT . DS . 'vendor' . DS.'tcpdf/tcpdf.php');

class PdfHandlerComponent extends Component
{
    public $components = ['Common','QrCodeHandler'];

    public function initialize(array $config = [])
    {
        parent::initialize($config);

        $this->controller = $this->_registry->getController();

    }

    function __isFileExist($file) {

        if ($data =  getimagesize($file)) {
            return true;
        } else {
            throw new Exception('yes');

        }
    }

    function __fileExistCheck($altname='',$file) {

        if ($data =  getimagesize($file)) {
            $imagepath='<img alt="'.$altname.'"  src="'.$file.'" /> ';
            if($altname=='logo'){
                $imagepath='<img alt="'.$altname.'"  src="'.$file.'" style="max-width:66px" /> ';
            }

            return $imagepath;
        } else {
            throw new Exception('yes');

        }
    }


    function writeOrderPdfFile($attendee)
    {
        /*$url    =    Router::url('/', true);
        $qrcode_img = $url . $qrcode;


        try{
            $qrcode = $this->__fileExistCheck('qrcode',$qrcode_img);
        }catch (Exception $e){
            if($e->getMessage()=='yes') {
                $qrcode = '';
            }
        }*/

        // Include the main TCPDF library (search for installation path).

        require_once(ROOT. DS .'vendor'.DS.'tcpdf/config/tcpdf_config.php');
        require_once(ROOT . DS . 'vendor' . DS.'tcpdf/tcpdf.php');

        // clean the output buffer
        ob_clean();
        $page_format = 'A4';
        // create new PDF document
        //  $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $page_format, true, 'UTF-8', false);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        mb_internal_encoding('UTF-8');
// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('FICTIONSOFT');
        $pdf->SetTitle('PRESCRIPTION');
        $pdf->SetSubject('PRESCRIPTION DETAIL');
        $pdf->SetKeywords('TCPDF, PDF, PRESCRIPTION');

// set image scale factor
        $pdf->setCellPaddings(0, 0, 0, 0);
        $pdf->setImageScale(1.53);


        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+5, PDF_MARGIN_RIGHT);


// remove default header/footer
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(false);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//Disable
        $pdf->setTextShadow(array('enabled'=>false, 'depth_w'=>1, 'depth_h'=>1, 'color'=>array(255,0,0), 'opacity'=>1, 'blend_mode'=>'Normal'));

// set some language-dependent strings (optional)
        /*if (@file_exists(WWW_ROOT . 'libraries/tcpdf/lang/eng.php')) {
            require_once(WWW_ROOT . 'libraries/tcpdf/lang/eng.php');
            $pdf->setLanguageArray($l);
        }*/

        // $pdf->AddPage('P', $page_format);
        $pdf->setJPEGQuality(100);


        $html_pdf   ='
<style>
*{
	font-family:Verdana, Geneva, sans-serif;
}
.company-logo{
	width:190px;
	max-width:66px
}
.header-contact{
	width:150px;
}
.header-content td{
	color:#717171;
	text-align:left;
	font-size:11px;
	line-height:13px;
}
.header-contact-last{
	color:#717171;
	text-align:left;
	font-size:11px;
	line-height:15px;
}
.invoice-left-part{
	color:#8b9090;
	text-align:left;
	font-size:11px;
	line-height:15px;
}.sponsor {
    font-size: 8px;
    color: #000;
    position: absolute;
    right: 15px;
    bottom: 2px;
    margin: 0;
    z-index: 99;
}table.table-img{
background-color: #00ad35;
}
</style>';
        $first_part = $this->firstPgprepareOrderPdfHtml($attendee);
        $html_pdf .= $first_part['message'];

        if(!$first_part['status']){
            return array('status'=>false,'message'=>$html_pdf);
        }

        $pdf->AddPage();
        try {

            $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html_pdf, $border = 0, $ln = 0, $fill = 0, $reseth = true, $align = '', $autopadding = false);

        } catch (Exception $e) {
            return '';
        }
        //$this->log($html_pdf);
        $upload_directory = 'uploads/pdf/';

        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 755, true);

            if (!is_writable($upload_directory)) {
                return array('status'=>false, 'message'=>$this->controller->msg->display($this->controller->name,'msg_invoice_generate_error') );
            }
        }

        $attendee_pdf_file = $upload_directory.'prescription-'.time().'.pdf';
        $pdf->Output($attendee_pdf_file, 'F');
        return $attendee_pdf_file;
    }


    function firstPgprepareOrderPdfHtml($attendee)
    {
        /*$url    =    Router::url('/', true);
        $devider_img = $url . 'img/pdf/divider.png';

        try {
            $devider_img = $this->__fileExistCheck('devider',$devider_img);
        }catch(Exception $e) {
            if($e->getMessage()=='yes') {
                $devider_img = '';
            }
        }*/

        $html = '
                <table>
                    <tr>
                        <td>Logo</td>
                        <td>
                            <h2>College Name</h2>
                        </td>
                        <td>
                            &nbsp;
                        </td>
                    </tr>
                </table>
                ';

        $html_pdf = $html;
        return array('status'=>true,'message'=>$html_pdf);
    }

    //creating base64 encoding
    function image_to_base64($path_to_image)
    {

        $type = pathinfo($path_to_image, PATHINFO_EXTENSION);
        // if(file_exists($path_to_image)){}
        $image = file_get_contents($path_to_image);

        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($image);

        return $base64;
    }


    function test(){
        die('Found');
    }


}
class MYPDF extends TCPDF {

    function __isFileExist($file) {

        if ($data =  getimagesize($file)) {
            return true;
        } else {
            throw new Exception('yes');

        }
    }
    function __fileExistCheck($altname='',$file, $height = null) {

        if ($data =  getimagesize($file)) {

            if(($height)) {
                $imagepath = '<img alt="' . $altname . '" height="'.$height.'" src="' . $file . '" /> ';

            }else{
                $imagepath = '<img alt="' . $altname . '"  src="' . $file . '" /> ';
            }
            return $imagepath;
        } else {
            throw new Exception('yes');

        }
    }


    //Page header
    public function Header() {
        /*$url    =    Router::url('/', true);
        $logo_img = $url  . 'img/logo.png';
        $site_email = Configure::read('Site.email');
        $site_name = Configure::read('Site.name');

        try{
            $logo_img = $this->__fileExistCheck('logo',$logo_img);
        }catch (Exception $e){
            if($e->getMessage()=='yes') {
                $logo_img = '';
            }
        }*/

        $html ='';
        // Logo
        /*$html = '
		<table width="100%" cellpadding="0" cellspacing="0"  border="0" align="left">
			<tr><td style="height:30px;"></td></tr>
	    </table>
		<table width="100%" cellpadding="0" cellspacing="0"  border="0" class="header-content">
           <tr>
                <td valign="top" align="left" class="company-logo">'.$logo_img.' </td>
                <td valign="top" align="left" class="company-logo">'.$site_name.' <br/>'.$site_email.'</td>
            </tr>
        </table>
        ';*/
        echo $html;
        $this->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = 'top', $autopadding = true);

    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $html = '<table width="100%" cellpadding="0" cellspacing="0"  border="0"><tr><td valign="top" align="center">Signature </td></tr></table> ';
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
