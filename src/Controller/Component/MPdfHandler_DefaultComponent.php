<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;
use Mpdf\Mpdf;

class MPdfHandler_DefaultComponent extends Component
{
    function writeOrderPdfFile($prescription, $latest_prescription)
    {
        require_once(ROOT . DS . 'vendor/autoload.php');

        $mpdf = new mpdf();

        $stylesheet = file_get_contents(WWW_ROOT . '/css/admin_styles/css/pdf.css');
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
                <style type="text/css">  
                    body{
                        font-size: 12px;
                    }                    
                </style>
            </head>

             <div class="printableArea cu_con_inner_view2">
                <div class="prescription_head default_prescription">
                    <div class="row">
    
                        <div class="col-sm-12">
                            <div class="col-sm-3 padding_right_two_percent">
                                <div class="doctor_image" style="border: 2px solid #0000FE;border-radius: 10px;">
                                    <img style="width: 100%;height: 200px;" src="' . $profile_pic . '">
                                </div>
                            </div>
    
                            <div class="col-sm-9">
                                <div class="doctor_info single_section default_prescription_info">
                                    <h1>' . ($user['first_name']) . ' ' . ($user['last_name']) . '</h1>
                                    <p>' . ($user['educational_qualification']) . '</p>';
                                    if ($user['specialist']) {
                                        $html .= '<p>' . ($user['specialist']) . '</p>';
                                    }
                                    if ($user['clinic_name']) {
                                        $html .= '<p>' . ($user['clinic_name']) . '</p>';
                                    }
                                    if ($user['cember_name']) {
                                        $html .= '<p>Chamber - ' . $user['cember_name'] . ' ' . $user['cember_address'];
                                    }
                                    $html .= '</div>
                            </div>
                        </div>
    
                    </div>
                </div>
    
                <div class="header_bottom_default_prescription">
                    <div class="row">
    
                        <div class="col-sm-12">
                            <div class="col-sm-3 padding_right_two_percent">
                                <div class="patient_details_default_prescription single_section">
                                    <h2>PATIENT</h2>
                                    <div class="info">
                                        <p><b>Name :</b> ' . ucfirst($prescription->user->first_name) . '</p>
                                        <p><b>Weight :</b> ' . ucfirst($prescription->user->weight) . '</p>
                                        <p><b>Age :</b> ' . $prescription->user->age . ' Years </p>
                                        <p><b>Phone :</b> ' . $prescription->user->phone . '</p>
                                        <p><b>Address :</b> ' . ucfirst($prescription->user->address_line1) . '</p>
                                    </div>
                                </div>
    
                                <div class="diagnosis_default_prescription single_section">
                                    <h2>DIAGNOSIS</h2>
                                    <div class="info">
                                        <p><b>Date :</b> ' . $prescription->created->format('d F Y') . '</p>';

                                        $i = 1;
                                        foreach ($prescription->diagnosis as $diagnosis) {
                                            $html .= '<p><b> ' . $i . '.</b> ' . ucfirst($diagnosis['diagnosis_list']['name']) . '</p>';
                                            $i++;
                                        }

                                        $html .= '<p><b>BP :</b> ' . ucfirst($prescription->blood_pressure) . '</p>

                                        <p><b>Tem :</b> ' . $prescription->temperature . '</p>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-sm-9">
                                <div class="medicines_default_prescription single_section">
                                    <h2>MEDICINES</h2>
                                    <div class="info">
                                        <ul>';
                                            foreach ($prescription->medicines as $medicine) {
                                                $html .= '<li>
                                                    <p>' . ucfirst($medicine->name) . (($medicine->_joinData->rule) ? ' : ( ' . $medicine->_joinData->rule . ' )' : '') . '</p>
                                                </li>';
                                            }
                                        $html .= '</ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="instruction_deafult_prescription">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-3 padding_right_two_percent">
                                <div class="examination_default_prescription single_section">
                                    <h2>EXAMINATION</h2>
                                    <div class="info">';

                                        $i = 1;
                                        foreach ($prescription->tests as $test) {
                                            $html .= '<p><b>' . $i . '.</b> ' . ucfirst($test->name) . '</p>';
                                            $i++;
                                        }

                                    $html .= '</div>
                                </div>
                            </div>
    
                            <div class="col-sm-9">
                                <div class="instruction_default_prescription single_section">
                                    <h2>OTHERS INSTRUCTIONS</h2>
                                    <div class="info">
                                        <p>' . ucfirst($prescription->other_instructions) . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                 <div class="doctors_note_default_prescription">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="col-sm-6 padding_right_two_percent">
                                <div class="single_section">
                                    <h2>Cheif Complain</h2>
                                    <div class="info">
                                        <p>' .ucfirst($prescription->doctores_notes) .'</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="single_section">
                                    <h2>On Examination</h2>
                                    <div class="info">
                                        <p>' .ucfirst($prescription->on_examination) .'</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
    
                <div class="footer_default_prescription">
                    <div class="row">
                          <div class="col-sm-12">
                              <div class="col-sm-6">
                                  <p><b>Address :</b> ' . ($user['address_line1']) . ' ' . ($user['address_line2']) . '</p>
                                  <p><b>For Booking Call :</b> ' . ($user['phone']) . '</p>
                                  <p>Must make booking before visiting the doctor.</p>
                              </div>
    
                              <div class="col-sm-2">&nbsp;</div>
    
                              <div class="col-sm-4">
                                  <p><b>Visiting Time :</b> ' . ($user['visiting_time']) . '</p>
                                  <p><b>Off Day :</b> ' . ($user['off_day']) . '</p>
                                  <p><b>Website :</b> ' . ($user['website']) . '</p>
                              </div>
                          </div>
                    </div>
                </div>
            </div>
        </body>';

        return $html;
    }
}