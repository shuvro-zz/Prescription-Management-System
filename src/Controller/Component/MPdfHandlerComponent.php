<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Mpdf\Mpdf;

class MPdfHandlerComponent extends Component
{
    function writeOrderPdfFile($prescription, $latest_prescription)
    {
        require_once(ROOT . DS . 'vendor/autoload.php');

        $mpdf = new mpdf();

        $stylesheet = file_get_contents(WWW_ROOT . '/css/admin_styles/css/pdf.css');
        $mpdf->falseBoldWeight = 10;
        $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

        $html = $this->preparePdfHtml($prescription, $latest_prescription);

        $mpdf->WriteHTML($html);

        $upload_directory = 'uploads/pdf/';

        if (!file_exists($upload_directory)) {
            mkdir($upload_directory, 755, true);

            if (!is_writable($upload_directory)) {
                return array('status' => false, 'message' => $this->controller->msg->display($this->controller->name, 'msg_invoice_generate_error'));
            }
        }

        $pdf_file = $upload_directory . 'prescription-' . time() . '.pdf';
        $mpdf->Output($pdf_file, 'F');

        return $pdf_file;
    }


    function preparePdfHtml($prescription, $latest_prescription)
    {
        $user = $this->request->session()->read('Auth.User');

        $url = Router::url('/', true);
        if (($user['profile_picture'])) {
            $profile_pic = $url . 'uploads/users/' . $user['profile_picture'];
        } else {
            $profile_pic = $url . 'css/admin_styles/images/dashboard-students.png';
        }

        $html = '<body>
            <head>
                <style>
                    p {
                        font-size: 12px;
                    }
                    .col-sm-6{width: 47.3%;}
                    .col-sm-4{width: 35.1%;}
                </style>
            </head>

             <div class="printableArea cu_con_inner_view2">
                 <div class="printableArea cu_con_inner_view2 final_prescription">

                    <!--Header-->
                    <div class="final_prescription_head final_prescriptoin_single_section">
                        <div class="row margin_remove">
    
                            <div class="col-sm-2 final_prescription_single_info">
                                <div class="final_prescriptoin_logo" style="padding:0px 5px">
                                    <img style="height: 103px; width: 100%;" src="css/admin_styles/images/Prescription_Template_logo.png" alt="image">
                                </div>
                            </div>
    
                            <div class="col-sm-6 final_prescription_single_info padding_remove">
                                <div class="final_prescriptoin_doctor_info">
                                    
                                    <h1>' .($user['first_name']).' '.($user['last_name']) . '</h1>
                                    <p>' .($user['educational_qualification']) .'</p>';

                                    if($user['specialist']){
                                        $html .= '<p>' .($user['specialist']) .'</p>';
                                    }

                                    if($user['clinic_name']){
                                        $html .= '<p>' .($user['clinic_name']) .'</p>';
                                    }

                                    if ($user['cember_name']) {
                                        $html .= '<p>Chamber - ' . $user['cember_name'] . ' ' . $user['cember_address'];
                                    }

                                $html .= '</div>
                            </div>
    
                            <div class="col-sm-4 final_prescription_date_phn_area">
                                <div class="row">
                                    <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Date</p></div>
                                    <div class="col-sm-6 padding_remove align_center"><p>' .$prescription->created->format('d F Y') .'</p></div>
                                </div>
    
                                <div class="row">
                                    <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Phone</p></div>
                                    <div class="col-sm-6 padding_remove align_center"> <p>' .($user['phone']). '</p></div>
                                </div>
    
                                <div class="row" style="border-bottom: none">
                                    <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Prescription ID</p></div>
                                    <div class="col-sm-6 padding_remove align_center"><p></p></div>
                                </div>
    
                            </div>
                        </div>
                    </div>
    
                    <!--Header bottom-->
                    <div class="header_bottom_final_prescription">
                        <div class="row margin_remove">
    
                            <div class="col-sm-3 padding_left_remove padding_right_two_percent">
                                <div class="final_prescriptoin_single_section">
                                    <p class="final_prescription_heading">Name</p>
                                    <p>' .ucfirst($prescription->user->first_name). '</p>
                                </div>
                            </div>
    
                            <div class="col-md-9 padding_remove">
                                <div class="final_prescriptoin_single_section">
                                
                                    <div class="col-sm-2 padding_remove">
                                        <div class="final_prescription_single_info">
                                            <p class="final_prescription_heading">Age</p>
                                            <p>' .$prescription->user->age .' Years' .'</p>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-3 padding_remove">
                                        <div class="final_prescription_single_info">
                                            <p class="final_prescription_heading">Sex</p>
                                            <p>' .$prescription->user->sex. '</p>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-3 padding_remove">
                                        <div class="final_prescription_single_info">
                                            <p class="final_prescription_heading">Weight</p>
                                            <p>' .ucfirst($prescription->user->weight). '</p>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-2 padding_remove">
                                        <div class="final_prescription_single_info">
                                            <p class="final_prescription_heading">BP</p>
                                            <p>' .ucfirst($prescription->blood_pressure). '</p>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-2 padding_remove">
                                        <p class="final_prescription_heading">Temp</p>
                                        <p>' .$prescription->temperature. '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <!--Medicines area-->
                    <div class="medicine_area_final_prescription">
                        <div class="row margin_remove">
    
                            <div class="col-sm-3 padding_left_remove padding_right_two_percent">
                                <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area margin_bottom_10">
                                    <p class="final_prescription_heading">Cheif Complain</p> <!--doctors note-->
    
                                    <div class="final_prescription_cheif_complain">
                                        <p>' .ucfirst($prescription->doctores_notes). '</p>
                                    </div>
    
                                </div>
    
                                <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area margin_bottom_10">
                                    <p class="final_prescription_heading">On Examination</p>
    
                                    <div class="final_prescription_cheif_complain">
                                        <p>' .ucfirst($prescription->on_examination). '</p>
                                    </div>
    
                                </div>
    
                                <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                    <p class="final_prescription_heading">Advice/Investigation</p>
    
                                    <div class="final_prescription_cheif_complain">';

                                        $i = 1;
                                        foreach ($prescription->tests as $test){
                                            $html .= '<p>' .$i. '. ' .ucfirst($test->name). '</p>';
                                            $i++;
                                        }
                                        $prescription_bg = "css/admin_styles/images/Prescription_Template_bg.png";
                                    $html .= '</div>
    
                                </div>
                            </div>
    
                            <div class="col-sm-9 padding_remove">
                                <div class="final_prescriptoin_single_section final_prescription_medicine_area" style="background-image: url(' .$prescription_bg. '); ">
                                    <p class="final_prescription_heading">Rx(Medicines)</p>
                                    <div class="final_prescription_medicine">';

                                        $i = 1;
                                        foreach ($prescription->medicines as $medicine){
                                            $html .= '<p>'. $i. '. ' .ucfirst($medicine->name).(($medicine->_joinData->rule)? ' : ( '.$medicine->_joinData->rule.' )': "").'</p>';
                                            $i++;
                                        }

                                    $html .= '</div>
                                </div>
                            </div>
    
                        </div>
                    </div>
    
                    <!--Diagnosis Area-->
                    <div class="diagnosis_area_final_prescription">
                        <div class="row margin_remove">
    
                            <div class="col-sm-3 padding_left_remove padding_right_two_percent">
                                <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                    <p class="final_prescription_heading">Diagnosis</p>
    
                                    <div class="final_prescription_cheif_complain">';

                                        $i = 1;
                                        foreach($prescription->diagnosis as $diagnosis ) {
                                            $html .= '<p>'.$i.'. ' .ucfirst($diagnosis['diagnosis_list']['name']). '</p>';
                                            $i++;
                                        }

                                    $html .= '</div>
    
                                </div>
                            </div>
    
                            <div class="col-sm-9 padding_remove">
                                <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                    <p class="final_prescription_heading">Other Instructions</p>
                                    <div class="final_prescription_cheif_complain">
                                        <p>' .ucfirst($prescription->other_instructions). '</p>
                                    </div>
                                </div>
                            </div>
    
                        </div>
                    </div>
    
                    <!--Footer top area-->
                    <div class="footer_top_final_prescription diagnosis_area_final_prescription">
                        <div class="row margin_remove">
    
                            <div class="col-sm-3 padding_left_remove padding_right_two_percent">
                                <div class="final_prescriptoin_single_section final_prescription_single_signature">
                                    <p>Software Promotion</p>
                                </div>
                            </div>
    
                            <div class="col-sm-9 padding_remove">
    
                                <div class="final_prescriptoin_single_section">
                                    <div class="col-sm-3 padding_remove">
                                        <div class="final_prescription_single_signature final_prescription_single_info">
                                            <p>Signature</p>
                                        </div>
                                    </div>
        
                                    <div class="col-sm-9 padding_remove">
                                        <div class="final_prescription_single_signature">
        
                                        </div>
                                    </div>
                                    </div>                               
                                </div>    
                        </div>
                    </div>
    
                    <!--Footer area-->                                                            
                    <div class="footer_final_prescription final_prescriptoin_single_section">
                        <div class="row margin_remove">
    
                            <div class="col-sm-6 padding_remove">
                                <div class="">
                                    <p style="font-family: sans-serif"><b>Address: </b>' .($user['address_line1']).' '.($user['address_line2']). '</p>
                                    <p style="font-family: sans-serif"><b>Call For Booking: </b>' .($user['phone']) .'</p>
                                    <p style="font-family: sans-serif">Must make booking before visiting the doctor.</p>
                                </div>
                            </div>
                            
                            <div class="col-sm-2">&nbsp;</div>
        
                            <div class="col-md-4 padding_remove">
                                <div class="">
                                    <p style="font-family: sans-serif"><b>Visiting Time: </b>' .($user['visiting_time']). '</p>
                                    <p style="font-family: sans-serif"><b>Off Day: </b>' .($user['off_day']). '</p>
                                    <p style="font-family: sans-serif"><b>Website: </b>' .($user['website']) .'</p>
                                </div>
                            </div>
    
                        </div>
                    </div>    
                </div>
             </div>
        </body>';

        return $html;
    }
}