<?php use \Cake\Core\Configure; ?>
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
            <?php echo $this->Flash->render('admin_warning'); ?>
        </div>

        <div class="cu_con_outer" id="printable_area">
            <div class="printableArea cu_con_inner_view2">
                <div class="prescription_head prescription_view2_head">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="prescription_head_con_view2">
                                <?php $user = $this->request->session()->read('Auth.User'); ?>
                                <b><h4 style="color: #000"> <?php echo ($user['first_name']).' '.($user['last_name']) ?> </h4></b>

                                <?php if($user['educational_qualification']){?>
                                    <p class="view2_education"> <?php echo ($user['educational_qualification']) ?> </p>
                                <?php } ?>

                                <?php if($user['specialist']){?>
                                    <b><p class="clinic_name" style="color: #000"> <?php echo ($user['specialist']) ?> </p></b>
                                <?php } ?>

                                <?php if($user['clinic_name']){?>
                                    <b><p class="clinic_name" style="color: #000"> <?php echo ($user['clinic_name']) ?> </p></b>
                                <?php } ?>

                                <b><p style="color: #000"   > <?php echo ($user['address_line1']).','.($user['address_line2']) ?> </p></b>
                                <!--<a href="#"><b><p> <?php /*echo ($user['website']) */?> </p></b></a>-->
                                <p> Call: <?php echo ($user['phone']) ?></p>

                                <?php if($user['website']){?>
                                    <p> <?php echo ($user['website']) ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="view2_prescription">

                    <div class="patient_info_area">
                        <div class="row">
                            <div class="col-sm-3">
                                <p><b>Name : </b> <?= ucfirst($prescription->user->first_name) ?></p>
                            </div>
                            <div class="col-sm-3">
                                <p><b>Mobile : </b> <?= $prescription->user->phone ?></p>
                            </div>
                            <div class="col-sm-4">
                                <p><b>Address : </b> <?= ucfirst($prescription->user->address_line1) ?> </p>
                            </div>
                            <div class="col-sm-2">
                                <p> <b>Age : </b> <?= $prescription->user->age .' Years' ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="patient_info_bottom">
                        <div class="row">
                            <div class="col-sm-4" style="border-right: 2px solid">

                                <b><span style="margin-left: 24px">Diagnosis</span></b>
                                <ul>
                                    <?php
                                    foreach($prescription->diagnosis as $diagnosis ) {
                                        echo "<li>".ucfirst($diagnosis['diagnosis_list']['name'])."</li>";
                                    }
                                    ?>
                                </ul>

                                <b><span style="margin-left: 24px">Tests</span></b>
                                <ul>
                                    <?php
                                    foreach ($prescription->tests as $test){
                                        echo "<li>".ucfirst($test->name)."</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-sm-5">

                                <b><span style="margin-left: 24px">Medicines</span></b>
                                <ul>
                                    <?php
                                    foreach ($prescription->medicines as $medicine){
                                        echo '<li>
                                                <span class="">'. ucfirst($medicine->name) .' :</span>
                                               '.(($medicine->_joinData->rule)? '<span>( '.$medicine->_joinData->rule.' )</span>': "-").'
                                            </li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col-sm-3">
                                <p style="text-align: right"><b>Date:</b> <?= $prescription->created->format('d F Y'); ?> </p>
                            </div>
                        </div>
                    </div>

                    <div class="classic_doctor_note">
                        <div class="row">
                            <div class="col-sm-12">
                                <p><?= ucfirst($prescription->doctores_notes) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="view2_prescription_footer prescription_footer">
                    <div class="row">
                        <div class="col-sm-5 offset-sm-2">
                            <div class="view2_cember_info" style="text-align: center">
                                <h4 style="color: #000;">Chamber:</h4>
                                <p style="color: #fff;"><?php echo $user['cember_name'] ?></p>
                                <p style="color: #fff"><?php echo $user['cember_address'] ?></p>
                            </div>
                        </div>

                        <div class="col-sm-2"></div>

                        <div class="col-sm-5">
                            <div class="view2_show_time" style="text-align: center">
                                <h4 style="color: #000;">Visiting Time:</h4>
                                <p style="color: #fff; flex-wrap: wrap"><?php echo $user['visiting_time'] ?></p>
                                <p style="color: #fff"><?php echo $user['off_day'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end prescription-->
            </div>
        </div>
        <input type="hidden" value="<?php echo $is_print ?>" id="is_print" name="is_print" >
    </div>
</div>