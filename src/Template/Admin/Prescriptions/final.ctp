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
            <div class="printableArea cu_con_inner_view2 final_prescription">

                <!--Header-->
                <div class="final_prescription_head final_prescriptoin_single_section">
                    <div class="row margin_remove">

                        <div class="col-sm-2 final_prescription_single_info padding_remove">
                            <div class="final_prescriptoin_logo">
                                <?php echo $this->Html->image('/css/admin_styles/images/Prescription_Template_logo.png', ['alt' => 'Logo']) ?>
                            </div>
                        </div>

                        <div class="col-sm-6 final_prescription_single_info">
                            <div class="final_prescriptoin_doctor_info">
                                <h1><?php echo ($user['first_name']).' '.($user['last_name']) ?></h1>
                                <p><?php echo ($user['educational_qualification']) ?></p>
                                <?php if($user['specialist']){?>
                                    <p> <?php echo ($user['specialist']) ?> </p>
                                <?php } ?>
                                <?php if($user['clinic_name']){?>
                                    <p> <?php echo ($user['clinic_name']) ?> </p>
                                <?php } ?>
                                <p>Chamber - <?php echo $user['cember_name'] ." ".$user['cember_address'] ?></p>
                            </div>
                        </div>

                        <div class="col-sm-4 padding_remove final_prescription_date_phn_area">
                            <div class="row margin_remove">
                                <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Date</p></div>
                                <div class="col-sm-6 padding_remove align_center"><p><?= $prescription->created->format('d F Y'); ?></p></div>
                            </div>

                            <div class="row margin_remove">
                                <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Phone</p></div>
                                <div class="col-sm-6 padding_remove align_center"> <p> <?php echo ($user['phone']) ?> </p></div>
                            </div>

                            <div class="row margin_remove">
                                <div class="col-sm-6 padding_remove final_prescription_single_info level"><p>Prescription ID</p></div>
                                <div class="col-sm-6 padding_remove align_center"><p></p></div>
                            </div>

                        </div>
                    </div>
                </div>

                <!--Header bottom-->
                <div class="header_bottom_final_prescription">
                    <div class="row margin_remove">

                        <div class="col-sm-3 padding_left_remove">
                            <div class="final_prescriptoin_single_section">
                                <p class="final_prescription_heading">Name</p>
                                <p><?= ucfirst($prescription->user->first_name) ?></p>
                            </div>
                        </div>

                        <div class="col-md-9 final_prescriptoin_single_section padding_remove">
                            <div class="col-sm-2 padding_remove">
                                <div class="final_prescription_single_info">
                                    <p class="final_prescription_heading">Age</p>
                                    <p><?= $prescription->user->age .' Years' ?></p>
                                </div>
                            </div>

                            <div class="col-sm-3 padding_remove">
                                <div class="final_prescription_single_info">
                                    <p class="final_prescription_heading">Sex</p>
                                    <p><?= $prescription->user->sex ?></p>
                                </div>
                            </div>

                            <div class="col-sm-3 padding_remove">
                                <div class="final_prescription_single_info">
                                    <p class="final_prescription_heading">Weight</p>
                                    <p><?= ucfirst($prescription->user->weight  ) ?></p>
                                </div>
                            </div>

                            <div class="col-sm-2 padding_remove">
                                <div class="final_prescription_single_info">
                                    <p class="final_prescription_heading">BP</p>
                                    <p><?= ucfirst($prescription->blood_pressure) ?></p>
                                </div>
                            </div>

                            <div class="col-sm-2 padding_remove">
                                <p class="final_prescription_heading">Temp</p>
                                <p><?= $prescription->temperature ?></p>
                            </div>
                        </div>

                    </div>
                </div>

                <!--Medicines area-->
                <div class="medicine_area_final_prescription">
                    <div class="row margin_remove">

                        <div class="col-sm-3 padding_left_remove">
                            <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area margin_bottom_10">
                                <p class="final_prescription_heading">Cheif Complain</p> <!--doctors note-->

                                <div class="final_prescription_cheif_complain">
                                    <p><?= ucfirst($prescription->doctores_notes) ?></p>
                                </div>

                            </div>

                            <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area margin_bottom_10">
                                <p class="final_prescription_heading">On Examination</p>

                                <div class="final_prescription_cheif_complain">
                                    <p><?= ucfirst($prescription->on_examination) ?></p>
                                </div>

                            </div>

                            <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                <p class="final_prescription_heading">Advice/Investigation</p>

                                <div class="final_prescription_cheif_complain">
                                    <?php
                                        $i = 1;
                                        foreach ($prescription->tests as $test){
                                            echo "<p>" .$i. ". ".ucfirst($test->name)."</p>";
                                            $i++;
                                        }
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-9 padding_remove">
                            <div class="final_prescriptoin_single_section final_prescription_medicine_area">
                                <p class="final_prescription_heading">Rx(Medicines)</p>
                                <div class="final_prescription_medicine">
                                    <?php
                                        $i = 1;
                                        foreach ($prescription->medicines as $medicine){
                                            echo '<p>'. $i. ". ". ucfirst($medicine->name).(($medicine->_joinData->rule)? ' : ( '.$medicine->_joinData->rule.' )': "").'</p>';
                                            $i++;
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!--Diagnosis Area-->
                <div class="diagnosis_area_final_prescription">
                    <div class="row margin_remove">

                        <div class="col-sm-3 padding_left_remove">
                            <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                <p class="final_prescription_heading">Diagnosis</p>

                                <div class="final_prescription_cheif_complain">
                                    <?php
                                        $i = 1;
                                        foreach($prescription->diagnosis as $diagnosis ) {
                                            echo "<p>".$i.". ".ucfirst($diagnosis['diagnosis_list']['name'])."</p>";
                                            $i++;
                                        }
                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-9 padding_remove">
                            <div class="final_prescriptoin_single_section final_prescription_cheif_complain_area">
                                <p class="final_prescription_heading">Other Instructions</p>
                                <div class="final_prescription_cheif_complain">
                                    <p><?= ucfirst($prescription->other_instructions) ?></p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!--Footer top area-->
                <div class="footer_top_final_prescription diagnosis_area_final_prescription">
                    <div class="row margin_remove">

                        <div class="col-sm-3 padding_left_remove">
                            <div class="final_prescriptoin_single_section final_prescription_single_signature">
                                <p>Software Promotion</p>
                            </div>
                        </div>

                        <div class="col-md-9 final_prescriptoin_single_section padding_remove">

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

                <!--Footer area-->
                <div class="footer_final_prescription final_prescriptoin_single_section">
                    <div class="row margin_remove">

                        <div class="col-sm-6 padding_remove">
                            <div class="">
                                <p><b>Address: </b> <?php echo ($user['address_line1']).' '.($user['address_line2']) ?></p>
                                <p><b>For Booking Call: </b> <?php echo ($user['phone']) ?></p>
                                <p>Must make booking before visiting the doctor.</p>
                            </div>
                        </div>

                        <div class="col-sm-2"></div>

                        <div class="col-md-4 padding_remove">
                            <div class="">
                                <p><b>Visiting Time: </b> <?php echo ($user['visiting_time']) ?></p>
                                <p><b>Off Day: </b> <?php echo ($user['off_day']) ?></p>
                                <p><b>Website: </b> <?php echo ($user['website']) ?></p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
