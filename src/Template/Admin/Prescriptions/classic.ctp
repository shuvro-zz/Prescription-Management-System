<?php use \Cake\Core\Configure; ?>
<div class="workspace-dashboard page page-ui-tables">
    <div class="workspace-body">
        <div class="page-heading">
            <div class="flex-container">
                <div class="flex-item">
                    <ol class="breadcrumb breadcrumb-small">
                        <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>"> <?= __('Prescription') ?></a></li>
                        <li class="active"><a  href="#">View <?= __('Prescription') ?></a></li>
                    </ol>
                </div>
                <div class="flex-item">
                    <div class="flex-container">
                        <a href="#" class="add-event-btn" id="printButton" title="Print Prescription">Print</a>&nbsp;&nbsp;&nbsp;

                        <?php
                        if(!Configure::read('is_localhost')) {
                            echo $this->Html->link(
                                'Generate pdf',
                                ['action' => 'generatePrescriptionPdf', $prescription->id],
                                ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Generate PDF ']
                            );
                            echo '
                                &nbsp;
                                &nbsp;';

                            $pdf_file_name = $prescription->pdf_file;
                            if ($pdf_file_name != NULL) {
                                echo '<a class="add-event-btn" href=' . $pdf_link . ' title="Download PDF"> Download Pdf </a>';
                                echo '
                                &nbsp;
                                &nbsp;';
                                if(Configure::read('email_send_allow')) {
                                    echo $this->Html->link(
                                        'Send Email',
                                        ['action' => 'sendPrescriptionEmail', $prescription->id],
                                        ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Send Email']
                                    );
                                    echo '
                                &nbsp;
                                &nbsp;';
                                }
                            }
                        }
                        ?>

                        <?php
                        echo $this->Html->link(
                            'edit prescription',
                            ['action' => 'edit', $prescription->id],
                            ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Edit Prescription']
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>

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

                                <?php if($user['clinic_name']){?>
                                    <b><p class="clinic_name" style="color: #000"> <?php echo ($user['clinic_name']) ?> </p></b>
                                <?php } ?>

                                <b><p style="color: #000"   > <?php echo ($user['address_line1']).','.($user['address_line2']) ?> </p></b>
                                <!--<a href="#"><b><p> <?php /*echo ($user['website']) */?> </p></b></a>-->
                                <b><p> Call: <?php echo ($user['phone']) ?></p></b>

                                <?php if($user['website']){?>
                                    <b><p> <?php echo ($user['website']) ?></p></b>
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

                    <div class="doctor_note">
                        <div class="row">
                            <div class="col-sm-12">
                                <p><?= ucfirst($prescription->doctores_notes) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="view2_prescription_footer">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="view2_cember_info" style="text-align: center">
                                <h4 style="color: #000;">Cember:</h4>
                                <p>Islamic Bank Hospital</p>
                                <p>Lokkhipur Mour, Rajshahi</p>
                            </div>
                        </div>

                        <div class="col-sm-2"></div>

                        <div class="col-sm-5">
                            <div class="view2_show_time" style="text-align: center">
                                <h4 style="color: #000;">Patient Show Time:</h4>
                                <p>Everyday Midday 2.30PM - Night 8PM</p>
                                <p>( Friday Off )</p>
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