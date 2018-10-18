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


    function writeOrderPdfFile($prescription,$latest_prescription)
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

        //$fontname = $pdf->addTTFfont(WWW_ROOT.'SolaimanLipi_20-04-07.ttf', 'TrueTypeUnicode', '', 32);

        // set font
       //$pdf->SetFont('solaimanlipi_200407', '', 12);

        $pdf->SetFont('solaimanlipi_200407', '', 12, '', false);

        $html_pdf   ='';
        $first_part = $this->firstPgprepareOrderPdfHtml($prescription,$latest_prescription);

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


    function firstPgprepareOrderPdfHtml($prescription,$latest_prescription)
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

        $user = $this->request->session()->read('Auth.User');

        /*Standard Template*/
        if ($this->request->session()->read('Auth.User')['prescription_template_id'] == 1) {//Standard Template
            $html = '
                <style>
    
                    table{
                        width:800px;
                        margin:0 auto;
                        margin-bottom: 25px;
    
                    }
                    table td{
                        line-height:23px;
                    }
                    .doctor_info{
                        font-size: 15px;color: #5d5d5d;font-weight:bold;
                    }
                    .patient_head, .test_head, .medicine_head{
                        font-weight: bold;
                        font-size: 20px;
                        color: #000;
                    }
                </style>
    
                 <table style="margin-bottom:0px; border-bottom:1px solid #eee;" >
                    <tr style="height:135px;">
    
                        <td style="width:100%; overflow:hidden;">
                            <table style="text-align:center;" >
                                <tr><td class="doctor_info" style="font-size:21px;">' . $user['clinic_name'] . '</td></tr>
                                <tr><td class="doctor_info">' . $user['first_name'] . ' ' . $user['last_name'] . '</td></tr>
                                <tr><td class="doctor_info">' . $user['educational_qualification'] . '</td></tr>
                                <tr><td class="doctor_info">' . $user['address_line1'] . $user['address_line2'] . '</td></tr>
                                <tr><td class="doctor_info">Call:' . $user['phone'] . '</td></tr>
                                <tr><td class="doctor_info">' . $user['website'] . '</td></tr>
                            </table>
                        </td>
    
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table style="color: #5d5d5d;">
                    <tr>
                        <td width="60%">
                            <table>
                                <tr><td class="patient_head">Patient</td></tr>
                                <tr><td>Name: ' . ucfirst($prescription->user->first_name) . '  Age:' . $prescription->user->age . ' Years' . '</td></tr>
                                <tr><td>Mobile: ' . $prescription->user->phone . '</td></tr>';

            if ($prescription->user->address_line1) {
                $html .= '<tr><td>Address: ' . ucfirst($prescription->user->address_line1) . '</td></tr>';
            }

            if ($prescription->user->temperature) {
                $html .= '<tr><td>Temperature: ' . ucfirst($prescription->temperature) . '</td></tr>';
            }
            if ($prescription->user->blood_pressure) {
                $html .= '<tr><td>Blood Pressure: ' . ucfirst($prescription->blood_pressure) . '</td></tr>';
            }

            $html .= '<tr><td>Diagnosis: ';
            foreach ($prescription->diagnosis as $diagnosis) {
                if ($diagnosis === end($prescription->diagnosis)) {
                    $html .= ucfirst($diagnosis['diagnosis_list']['name']) . "  ";
                } else {
                    $html .= ucfirst($diagnosis['diagnosis_list']['name']) . ", ";
                }
            }
            $html .= '</td></tr>';
            $html .= '</table>
                        </td>
                        <td width="40%" align="right">
                            Last Visited Date:' . $latest_prescription->created->format('d F Y') . '
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>';
            if ($prescription->medicines) {
                $html .= '<tr>
                           <td>
                                <table>
                                    <tr><td class="medicine_head">Medicines</td></tr>' ?>
                <?php
                foreach ($prescription->medicines as $medicine) {
                    $html .= '<tr>
                                            <td class="prescription_caption">' . ucfirst($medicine->name) . ' :
                                           ' . (($medicine->_joinData->rule) ? '( ' . $medicine->_joinData->rule . ' )' : "-") . '</td>
                                        </tr>';
                }
                $html .= '</table>
                           </td>
                        </tr>';
            }

            $html .= '<tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
    
                    <tr>
                        <td>
                            <table>';
            if ($prescription->tests) {
                $html .= '<tr><td class="test_head">Examination</td></tr><tr><td>' ?>
                <?php
                foreach ($prescription->tests as $test) {
                    if ($test === end($prescription->tests)) {
                        $html .= ucfirst($test->name) . "  ";
                    } else {
                        $html .= ucfirst($test->name) . ", ";
                    }
                }
                $html .= '</td></tr><tr><td>&nbsp;</td></tr>';
            }

            if ($prescription->doctores_notes) {
                $html .= '<tr><td class="test_head">Doctors Note:</td></tr>
                                    <tr><td>' . $prescription->doctores_notes . '</td></tr>
                                    <tr><td>&nbsp;</td></tr>';
            }
            if ($prescription->other_instructions) {
                $html .= '<tr><td class="test_head">Other Instructions:</td></tr>
                                    <tr><td>' . $prescription->other_instructions . '</td></tr>';
            }
            $html .= '</table>
                        </td>
                    </tr>
                </table>
    
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                <table style="border-top:1px solid #eee; color: #5d5d5d; ">
                    <tr style="height:50px;">
                        <td align="left" style="width:50%;">
                            Signature: ' . $user['first_name'] . ' ' . $user['last_name'] .
                '</td>
                        <td align="right" style="width:50%;">
                            Date: ' . $prescription->created->format('d F Y') . '
                        </td>
                    </tr>
                </table>
            ';
        }

        /*Classic Template*/
        if ($this->request->session()->read('Auth.User')['prescription_template_id'] == 2){//Classic Template
            $html = '
                <style>
                    table{
                        width:800px;
                        margin:0 auto;
                    }
                    table td{
                        line-height:23px;
                        padding: 0px 15px;
                    }
                    .doctor_info{
                        font-size: 15px;color: #5d5d5d;font-weight:bold;
                    }
                    .patient_head, .test_head, .medicine_head{
                        font-weight: bold;
                        font-size: 20px;
                        color: #000;
                    }                                             
                </style>
    
                 <table class="test" style="margin-bottom:0px; border-bottom:1px solid #000; background-color: #00A8DC" >
                    <tr>
                        <td style="width:100%; overflow:hidden;">
                            <table>
                                <tr><td class="doctor_info" style="font-size:21px;color: #000">'. ($user['first_name']).' '.($user['last_name']) .'</td></tr>';

                                if ($user['educational_qualification']){
                                    $html .=  '
                                        <table style="border: 1px solid #fff; width: 300px; margin: 0;padding-left: 8px">
                                            <tr><td class="doctor_info" style="color: #fff;">'. $user['educational_qualification'] .'</td></tr>
                                        </table>';
                                }

                                    $html .= '<tr><td class="doctor_info" style="color: #000">'. $user['clinic_name'] .'</td></tr>
                                            <tr><td class="doctor_info" style="color: #000">'. $user['address_line1'] .$user['address_line2'] .'</td></tr>
                                            <tr><td class="doctor_info" style="color: #fff;">Call:'. $user['phone'] .'</td></tr>
                                            <tr><td class="doctor_info" style="color: #fff;">' .$user['website']. '</td></tr>
                            </table>
                        </td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td><b>Name: </b>'. ucfirst($prescription->user->first_name).' </td>
                        <td><b>Mobile: </b>'. $prescription->user->phone.' </td>
                        <td align="right"><b>Address: </b>'. ucfirst($prescription->user->address_line1).' </td>
                        <td align="right"><b>Age: </b>'. $prescription->user->age .' Years'.' </td>
                    </tr>
                 </table>
    
                  <table style="border-bottom: 2px solid #000;margin-top: -5px;">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                 <table style="margin-top: 20px;margin-bottom: 20px;">
                    <tr>
                        <td  style="border-right: 2px solid #000;">
                            <table style="width: 100%;">
                                <tr><td style="font-size: 22px;"><b>Diagnosis:</b></td></tr>';

                                $i =1;
                                foreach($prescription->diagnosis as $diagnosis ) {
                                    if($diagnosis === end($prescription->diagnosis) ){
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($diagnosis['diagnosis_list']['name']).". ".'</td></tr>';
                                    }else{
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($diagnosis['diagnosis_list']['name']).", ".'</td></tr>';
                                    }
                                    $i++;
                                }

                                $html .= '
                            </table>
                            
                             <table>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                             </table>
                             
                            <table style="width:100%;">
                                <tr><td style="font-size: 22px"><b>Tests:</b></td></tr>';

                                $i =1;
                                foreach($prescription->tests as $test ) {
                                    if($test === end($prescription->tests) ){
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($test->name).". ".'</td></tr>';
                                    }else{
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($test->name).", ".'</td></tr>';
                                    }
                                    $i++;
                                }
                                $html .= '
                            </table>
                        </td>
                                        
                        <td>
                            <table style="width:100%;">
                                <tr><td style="font-size: 22px"><b>Medicines:</b></td></tr>';

                                $i =1;
                                foreach($prescription->medicines as $medicine ) {
                                    $html.= '<tr>
                                        <td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($medicine->name) .' :
                                            '.(($medicine->_joinData->rule)? '( '.$medicine->_joinData->rule.' )': "-").'                                        
                                        </td>
                                    </tr>';
                                    $i++;
                                }
                            $html .= '</table>
                        </td>
                    
                        <td align="right">
                            <b>Date: </b>'.$prescription->created->format('d F Y').'
                        </td>
                    </tr>
                 </table>
                 
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                 
              <table style="border-top: 2px solid #00A8DC;">
                  <tr>
                      <td>'.$prescription->doctores_notes.'</td>
                  </tr>
              </table>
              
              <table>
                <tr>
                    <td>&nbsp;</td>
                </tr>
             </table>';

                $html.= '
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                <table style="color: #000;text-align: center;background-color: #00A8DC;padding: 5px 0px">
                    <tr >
                        <td style="width:35%;">
                            <table style="width: 100%">
                                <tr><td><b>Cember:</b></td></tr>
                                <tr><td>Islamic Bank Hospital</td></tr>
                                <tr><td>Lokkhipur Mour, Rajshahi</td></tr>
                            </table>
                        </td>
    
                        <td style="width:20%;">
                             <table style="width: 100%">
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                             </table>
                         </td>
    
                        <td style="width:45%;">
                             <table style="width: 100%">
                                    <tr><td><b>Patient Show Time:</b></td></tr>
                                    <tr><td>Everyday Midday 2.30PM - Night 8PM</td></tr>
                                    <tr><td>Friday Off</td></tr>
                             </table>
                         </td>
    
                    </tr>
                </table>            
            ';
      }

        /*Custom Template*/
        if ($this->request->session()->read('Auth.User')['prescription_template_id'] == 3){//Custom Template
            $html = '
                <style>
    
                    table{
                        width:800px;
                        margin:0 auto;
                        background: rgb(240,183,161);  
                    }
                    table td{
                        line-height:23px;
                        padding: 0px 15px;
                    }
                    .doctor_info{
                        font-size: 15px;color: #5d5d5d;font-weight:bold;
                    }
                    .patient_head, .test_head, .medicine_head{
                        font-weight: bold;
                        font-size: 20px;
                        color: #000;
                    }
                                                            
                </style>
                 <table style="background-color: #DE346C" >
                    <tr>
                        <td style="width:100%; overflow:hidden;">
                            <table>
                                <tr><td class="doctor_info" style="font-size:21px;color: #000">'. ($user['first_name']).' '.($user['last_name']) .'</td></tr>';

                                if ($user['educational_qualification']){
                                    $html .=  '<tr><td class="doctor_info" style="color: #fff;">'. $user['educational_qualification'] .'</td></tr>';
                                }

                                $html .= '<tr><td class="doctor_info" style="color: #000">'. $user['clinic_name'] .'</td></tr>
                                        <tr><td class="doctor_info" style="color: #000">'. $user['address_line1'] .$user['address_line2'] .'</td></tr>
                                        <tr><td class="doctor_info" style="color: #fff;">Call:'. $user['phone'] .'</td></tr>
                                        <tr><td class="doctor_info" style="color: #fff;">' .$user['website']. '</td></tr>
                            </table>
                        </td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td><b>Name: </b>'. ucfirst($prescription->user->first_name).' </td>
                        <td><b>Mobile: </b>'. $prescription->user->phone.' </td>
                        <td align="right"><b>Address: </b>'. ucfirst($prescription->user->address_line1).' </td>
                        <td align="right"><b>Age: </b>'. $prescription->user->age .' Years'.' </td>
                    </tr>
                 </table>
    
                  <table style="border-bottom: 2px solid #000;">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                  <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                  <table>
                    <tr>
                        <td style="font-size: 22px;width: 30%"><b>Diagnosis:</b></td>
                        <td style="width: 70%;">
                            <table>';
                                $i=1;
                                foreach($prescription->diagnosis as $diagnosis ) {
                                            if($diagnosis === end($prescription->diagnosis) ){
                                                $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($diagnosis['diagnosis_list']['name']).". ".'</td></tr>';
                                            }else{
                                                $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($diagnosis['diagnosis_list']['name']).", ".'</td></tr>';
                                            }
                                    $i++;
                                }
                            $html .= '</table>
                        </td>
                    </tr>
                 </table>
                 
                 <table style="border-bottom: 1.8px solid #000;">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                 <table>
                    <tr>
                        <td style="font-size: 22px;width: 30%"><b>Tests:</b></td>
                        <td style="width: 70%;">
                            <table>';
                                $i = 1;
                                foreach($prescription->tests as $test ) {
                                    if($test === end($prescription->tests) ){
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($test->name).". ".'</td></tr>';
                                    }else{
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($test->name).", ".'</td></tr>';
                                    }
                                    $i++;
                                }
                            $html .= '</table>
                        </td>
                    </tr>
                 </table>
                 
                  <table style="border-bottom: 2px solid #000;">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                 <table>
                    <tr>
                        <td style="font-size: 22px;width: 30%"><b>Medicines:</b></td>
                        <td style="width: 50%;">
                            <table>';
                                $i = 1;
                                foreach($prescription->medicines as $medicine ) {
                                    $html.= '<tr>
                                                <td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($medicine->name) .' :
                                                    '.(($medicine->_joinData->rule)? '( '.$medicine->_joinData->rule.' )': "-").'                                        
                                                </td>
                                            </tr>';
                                    $i++;
                                }
                            $html .= '</table>
                        </td>
                        
                        <td >
                            <b>Date: </b>'.$prescription->created->format('d F Y').'
                        </td>
                        
                    </tr>
                 </table>                                                                   
                 
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                  <table style="border-top: 2px solid #DE346C;">
                      <tr><td>Notes: </td></tr>
                      <tr>
                          <td>'.$prescription->doctores_notes.'</td>
                      </tr>
                  </table>';

            $html.= '
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                <table style="color: #000;text-align: center;background-color: #DE346C;padding: 5px 0px">
                    <tr >
                        <td style="width:35%;">
                            <table style="width: 100%">
                                <tr><td><b>Cember:</b></td></tr>
                                <tr><td>Islamic Bank Hospital</td></tr>
                                <tr><td>Lokkhipur Mour, Rajshahi</td></tr>
                            </table>
                        </td>
    
                        <td style="width:20%;">
                             <table style="width: 100%">
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                             </table>
                         </td>
    
                        <td style="width:45%;">
                             <table style="width: 100%">
                                    <tr><td><b>Patient Show Time:</b></td></tr>
                                    <tr><td>Everyday Midday 2.30PM - Night 8PM</td></tr>
                                    <tr><td>Friday Off</td></tr>
                             </table>
                         </td>
    
                    </tr>
                </table>            
            ';
        }

        /*General Template*/
        if ($this->request->session()->read('Auth.User')['prescription_template_id'] == 4){//Classic Template
            $html = '
                <style>
                    table{
                        width:800px;
                        margin:0 auto;
                    }
                    table td{
                        line-height:23px;
                        padding: 0px 15px;
                    }
                    .doctor_info{
                        font-size: 15px;color: #5d5d5d;font-weight:bold;
                    }
                    .patient_head, .test_head, .medicine_head{
                        font-weight: bold;
                        font-size: 20px;
                        color: #000;
                    }                                             
                </style>
    
                 <table class="test" style="margin-bottom:0px; border-bottom:1px solid #000; background-color: #BCA48C" >
                    <tr>
                        <td style="width:100%; overflow:hidden;">
                            <table>
                                <tr><td class="doctor_info" style="font-size:21px;color: #000">'. ($user['first_name']).' '.($user['last_name']) .'</td></tr>';

                                if ($user['educational_qualification']){
                                    $html .=  '<tr><td class="doctor_info" style="color: #fff;">'. $user['educational_qualification'] .'</td></tr>';
                                }

                                $html .= '<tr><td class="doctor_info" style="color: #000">'. $user['clinic_name'] .'</td></tr>
                                        <tr><td class="doctor_info" style="color: #000">'. $user['address_line1'] .$user['address_line2'] .'</td></tr>
                                        <tr><td class="doctor_info" style="color: #fff;">Call:'. $user['phone'] .'</td></tr>
                                        <tr><td class="doctor_info" style="color: #fff;">' .$user['website']. '</td></tr>
                            </table>
                        </td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td><b>Name: </b>'. ucfirst($prescription->user->first_name).' </td>
                        <td><b>Mobile: </b>'. $prescription->user->phone.' </td>
                        <td align="right"><b>Address: </b>'. ucfirst($prescription->user->address_line1).' </td>
                        <td align="right"><b>Age: </b>'. $prescription->user->age .' Years'.' </td>
                    </tr>
                 </table>
    
                  <table style="border-bottom: 2px solid #000;">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                 <table style="margin-top: 20px;margin-bottom: 20px;">
                    <tr>
                        <td style="border-right: 2px solid #000;">
                            <table style="width: 100%;">
                                <tr><td style="font-size: 22px;"><b>Diagnosis:</b></td></tr>';

                                $i =1;
                                foreach($prescription->diagnosis as $diagnosis ) {
                                    if($diagnosis === end($prescription->diagnosis) ){
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($diagnosis['diagnosis_list']['name']).". ".'</td></tr>';
                                    }else{
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($diagnosis['diagnosis_list']['name']).", ".'</td></tr>';
                                    }
                                    $i++;
                                }
                             $html .= '</table>                                                                                                                                                                                                      
                        </td>                                                
                        
                        <td>                                                    
                            <table style="width:100%;">
                                <tr><td style="font-size: 22px"><b>Tests:</b></td></tr>';

                                $i =1;
                                foreach($prescription->tests as $test ) {
                                    if($test === end($prescription->tests) ){
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($test->name).". ".'</td></tr>';
                                    }else{
                                        $html .= '<tr><td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($test->name).", ".'</td></tr>';
                                    }
                                    $i++;
                                }
                            $html .= '</table>
                        </td>
                    </tr>
                 </table>
                 
                 <table style="border-bottom: 2px solid #000;">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
                 
                 <table>
                    <tr> 
                        <td></td>   
                        <td>   
                            <table style="width:100%;">
                                <tr><td style="font-size: 22px"><b>Medicines:</b></td></tr>';

                                $i =1;
                                foreach($prescription->medicines as $medicine ) {
                                    $html.= '<tr>
                                                <td class="doctor_info" style="color: #000">'.$i.'. '. ucfirst($medicine->name) .' :
                                                    '.(($medicine->_joinData->rule)? '( '.$medicine->_joinData->rule.' )': "-").'                                        
                                                </td>
                                            </tr>';
                                    $i++;
                                }
                            $html .= '</table>
                        </td>
                        
                        <td align="right">
                            <b>Date: </b>'.$prescription->created->format('d F Y').'
                        </td>
                    </tr>
                 </table>
                 
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
                 
              <table style="border-top: 2px solid #BCA48C;">
                  <tr>
                      <td>'.$prescription->doctores_notes.'</td>
                  </tr>
              </table>
              
              <table>
                <tr>
                    <td>&nbsp;</td>
                </tr>
             </table>';

            $html.= '
                <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                 <table>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                 </table>
    
                <table style="color: #000;text-align: center;background-color: #BCA48C;padding: 5px 0px">
                    <tr >
                        <td style="width:35%;">
                            <table style="width: 100%">
                                <tr><td><b>Cember:</b></td></tr>
                                <tr><td style="color: #fff;">Islamic Bank Hospital</td></tr>
                                <tr><td style="color: #fff;">Lokkhipur Mour, Rajshahi</td></tr>
                            </table>
                        </td>
    
                        <td style="width:20%;">
                             <table style="width: 100%">
                                    <tr><td></td></tr>
                                    <tr><td></td></tr>
                             </table>
                         </td>
    
                        <td style="width:45%;">
                             <table style="width: 100%">
                                    <tr><td><b>Patient Show Time:</b></td></tr>
                                    <tr><td style="color: #fff;">Everyday Midday 2.30PM - Night 8PM</td></tr>
                                    <tr><td style="color: #fff;">Friday Off</td></tr>
                             </table>
                         </td>
    
                    </tr>
                </table>            
            ';
        }
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
