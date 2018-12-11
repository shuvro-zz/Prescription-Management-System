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
                <div class="prescription_head default_prescription">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <div class="doctor_image">
                                    <img src="<?php echo $profile_pic; ?>">
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <div class="doctor_info single_section">
                                    <h1><?php echo ($user['first_name']).' '.($user['last_name']) ?></h1>
                                    <p><?php echo ($user['educational_qualification']) ?></p>
                                    <?php if($user['clinic_name']){?>
                                        <p> <?php echo ($user['specialist']) ?> </p>
                                    <?php } ?>
                                    <?php if($user['clinic_name']){?>
                                        <p> <?php echo ($user['clinic_name']) ?> </p>
                                    <?php } ?>
                                    <p>Chamber - <?php echo $user['cember_name'] .", ".$user['cember_address'] ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="header_bottom_default_prescription">
                    <div class="row">

                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <div class="patient_details_default_prescription single_section">
                                    <h2>PATIENT</h2>
                                    <div class="info">
                                        <p><b>Name:</b> <?= ucfirst($prescription->user->first_name) ?></p>
                                        <p><b>Age:</b> <?= $prescription->user->age .' Years' ?></p>
                                        <p><b>Phone:</b> <?= $prescription->user->phone ?></p>
                                        <p><b>Address:</b> <?= ucfirst($prescription->user->address_line1) ?></p>
                                    </div>
                                </div>

                                <div class="diagnosis_default_prescription single_section">
                                    <h2>DIAGNOSIS</h2>
                                    <div class="info">
                                        <p><b>Date:</b> <?= $prescription->created->format('d F Y'); ?></p>

                                        <?php
                                            $i = 1;
                                            foreach($prescription->diagnosis as $diagnosis ) {
                                                echo "<p><b>".$i.".</b> ".ucfirst($diagnosis['diagnosis_list']['name'])."</p>";
                                                $i++;
                                            }
                                        ?>

                                        <p><b>BP:</b> <?= ucfirst($prescription->blood_pressure) ?></p>
                                        <p><b>Tem:</b><?= $prescription->temperature ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <div class="medicines_default_prescription single_section">
                                    <h2>MEDICINES</h2>
                                    <div class="info">
                                        <ul>
                                            <?php
                                            foreach ($prescription->medicines as $medicine){
                                                echo '<li>
                                                <p class="">'. ucfirst($medicine->name) .'  : '.(($medicine->_joinData->rule)? '( '.$medicine->_joinData->rule.' )': "").'</p>                                               
                                            </li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="instruction_deafult_prescription">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-3">
                                <div class="examination_default_prescription single_section">
                                    <h2>EXAMINATION</h2>
                                    <div class="info">
                                        <?php
                                            $i = 1;
                                            foreach ($prescription->tests as $test){
                                                echo "<p><b>" .$i. ".</b> ".ucfirst($test->name)."</p>";
                                                $i++;
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-9">
                                <div class="instruction_default_prescription single_section">
                                    <h2>OTHERS INSTRUCTIONS</h2>
                                    <div class="info">
                                        <p><?= ucfirst($prescription->other_instructions) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="doctors_note_default_prescription">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <div class="single_section">
                                    <h2>DOCTORS NOTE</h2>
                                    <div class="info">
                                        <p><?= ucfirst($prescription->doctores_notes) ?></p>
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
                                  <p><b>Address:</b> <?php echo ($user['address_line1']).','.($user['address_line2']) ?> </p>
                                  <p><b>For Booking Call:</b>  <?php echo ($user['phone']) ?></p>
                                  <p>Must make booking before visiting the doctor.</p>
                              </div>

                              <div class="col-sm-6">
                                  <p><b>Visiting Time:</b>  <?php echo ($user['visiting_time']) ?></p>
                                  <p><b>Off Day:</b> <?php echo ($user['off_day']) ?></p>
                                  <p><b>Website:</b> <?php echo ($user['website']) ?></p>
                              </div>
                          </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>