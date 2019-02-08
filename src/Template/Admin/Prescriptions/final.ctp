<div class="workspace-dashboard page page-ui-tables">
    <div class="workspace-body">

        <?php include('page_heading.ctp'); ?>

        <?php
            $all_prescriptions=$all_prescriptions->toArray();
            if(count($all_prescriptions) > 1){
                echo'<div class="more_prescription">
                    <div class="more_prescription_inner"><b>Prescriptions: </b>';
                        $i=1;
                        foreach($all_prescriptions as $all_prescription){
                            if(count($all_prescriptions) == $i){
                                echo $this->Html->link(
                                    $all_prescription->created->format('d F Y').' ',
                                    ['action' => 'view', $all_prescription->id],
                                    ['escapeTitle' => false, 'class' => (($all_prescription->id == $this->request->params['pass'][0])?"current-item":""), 'title' => 'View Prescription']
                                );
                            }else{
                                echo $this->Html->link(
                                    $all_prescription->created->format('d F Y').', ',
                                    ['action' => 'view', $all_prescription->id],
                                    ['escapeTitle' => false, 'class' => (($all_prescription->id == $this->request->params['pass'][0])?"current-item":""), 'title' => 'View Prescription']
                                );
                            }
                            $i++;
                        }
                    echo'</div>
                </div>';
            }
        ?>

        <div class="col-md-12">
            <?php echo $this->Flash->render('admin_success'); ?>
            <?php echo $this->Flash->render('admin_error'); ?>
            <?php echo $this->Flash->render('admin_warning');

                $user = $this->request->session()->read('Auth.User');
                if (($user['profile_picture'])){
                    $profile_pic = $this->request->webroot.'uploads/users/'.$user['profile_picture'];
                }else{
                    $profile_pic = $this->request->webroot.'css/admin_styles/images/dashboard-students.png';
                }

            ?>
        </div>

        <div class="cu_con_outer" id="printable_area">
            <div class="printableArea cu_con_inner_view2">
                <div class="final_prescription_head final_prescriptoin_single_section">
                    <div class="row margin_remove">

                        <div class="col-sm-2 final_prescription_single_info padding_remove">
                            <div class="final_prescriptoin_logo">
                                <?php echo $this->Html->image('/css/admin_styles/images/Prescription_Template_logo.png', ['alt' => 'Logo']) ?>
                            </div>
                        </div>

                        <div class="col-sm-6 final_prescription_single_info">
                            <div class="final_prescriptoin_doctor_info">
                                <h1>MD Rezaul Kobir</h1>
                                <p>MBBS,M,D(Cardiology) BCS (Health)</p>
                                <p>Consaltent Cardiologist</p>
                                <p>Rajshahi Medical College, Rajshahi</p>
                                <p>Chamber - 154, Rajshahi Medical College</p>
                            </div>
                        </div>

                        <div class="col-sm-4 padding_remove final_prescription_date_phn_area">
                            <div class="row margin_remove">
                                <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Date</p></div>
                                <div class="col-sm-6 padding_remove align_center"><p>12/12/2019</p></div>
                            </div>

                            <div class="row margin_remove">
                                <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Phone</p></div>
                                <div class="col-sm-6 padding_remove align_center"><p>12/12/2019</p></div>
                            </div>

                            <div class="row margin_remove">
                                <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Prescription ID</p></div>
                                <div class="col-sm-6 padding_remove align_center"><p></p></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="header_bottom_final_prescription">
                    <div class="row margin_remove">

                        <div class="col-sm-3 padding_left_remove">
                            <div class="final_prescriptoin_single_section">
                                <p class="final_prescription_heading">Name</p>
                                <p>Abdullah Al Mamun</p>
                            </div>
                        </div>

                        <div class="col-md-9 final_prescriptoin_single_section padding_remove">
                            <div class="col-sm-2 padding_remove">
                                <div class="final_prescription_single_info">
                                    <p class="final_prescription_heading">Age</p>
                                    <p>22</p>
                                </div>
                            </div>

                            <div class="col-sm-3 padding_remove">
                                <div class="final_prescription_single_info">
                                    <p class="final_prescription_heading">Sex</p>
                                    <p>Male</p>
                                </div>
                            </div>

                            <div class="col-sm-3 padding_remove">
                                <div class="final_prescription_single_info">
                                    <p class="final_prescription_heading">Weight</p>
                                    <p>55k</p>
                                </div>
                            </div>

                            <div class="col-sm-2 padding_remove">
                                <div class="final_prescription_single_info">
                                    <p class="final_prescription_heading">BP</p>
                                    <p>Normal</p>
                                </div>
                            </div>

                            <div class="col-sm-2 padding_remove">
                                <p class="final_prescription_heading">Temp</p>
                                <p>F98</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="medicine_area_final_prescription">
                    <div class="row margin_remove">

                        <div class="col-sm-3 padding_left_remove">
                            <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                <p class="final_prescription_heading">Cheif Complain</p>

                                <div class="final_prescription_cheif_complain">
                                    <p>1. Abdominal Pain</p>
                                </div>

                            </div>

                            <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                <p class="final_prescription_heading">Cheif Complain</p>

                                <div class="final_prescription_cheif_complain">
                                    <p>1. Abdominal Pain</p>
                                </div>

                            </div>

                            <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                <p class="final_prescription_heading">Cheif Complain</p>

                                <div class="final_prescription_cheif_complain">
                                    <p>1. Abdominal Pain</p>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-9 padding_remove">
                            <div class="final_prescriptoin_single_section final_prescription_medicine_area">
                                <p class="final_prescription_heading">Rx(Medicines)</p>
                                <div class="final_prescription_medicine">
                                    <p>1. Abdominal Pain</p>
                                    <p>1. Abdominal Pain</p>
                                    <p>1. Abdominal Pain</p>
                                    <p>1. Abdominal Pain</p>
                                    <p>1. Abdominal Pain</p>
                                    <p>1. Abdominal Pain</p>
                                    <p>1. Abdominal Pain</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="doctors_note_default_prescription">
                    <div class="row">

                    </div>
                </div>

                <div class="final_prescription_footer_default_prescription">
                    <div class="row">

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
