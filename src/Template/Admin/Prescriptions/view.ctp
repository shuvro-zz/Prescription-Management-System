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
                        <a href="#" class="add-event-btn" id="printButton" title="Print Prescription">Print</a>
                        &nbsp;
                        &nbsp;

                        <?php
                        echo $this->Html->link(
                            'pdf Generate',
                            ['action' => 'generatePrescriptionPdf', $prescription->id],
                            ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'PDF Generate']
                        )
                        ?>
                        &nbsp;
                        &nbsp;
                        <!--<a class='add-event-btn' href='<?php /*echo $this->Url->build(WWW_ROOT.'/uploads/pdf/'.$pdf_file_name,true);*/?>'>Pdf Download</a>';-->
                        <?php

                        $pdf_file_name = $prescription->pdf_file;

                        if($pdf_file_name != NULL){

                            echo '<a class="add-event-btn" href='.$pdf_link.' title="PDF Download">Pdf Download</a>';
                            echo'
                            &nbsp;
                            &nbsp;';
                        }

                        ?>


                        <?php
                            echo $this->Html->link(
                            'Send Email',
                            ['action' => 'sendPrescriptionEmail', $prescription->id],
                            ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Send Email']
                            )
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
                                    ['escapeTitle' => false, 'title' => 'View Prescription']
                                );
                            }else{
                                echo $this->Html->link(
                                    $all_prescription->created->format('d F Y').', ',
                                    ['action' => 'view', $all_prescription->id],
                                    ['escapeTitle' => false, 'title' => 'View Prescription']
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
            <div class="printableArea cu_con_inner">
                <div class="prescription">
                    <div class="prescription_head">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="prescription_logo">
                                    <img src="http://hdwallpapersbuzz.com/wp-content/uploads/2017/04/rx-logo-4.png">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="prescription_head_con">
                                    <?php $user = $this->request->session()->read('Auth.User'); ?>
                                    <h1> <?php echo ($user['clinic_name']) ?> </h1>
                                    <b><p> <?php echo ($user['address_line1']) ?> </p></b>
                                    <a href="#"><b><p> <?php echo ($user['website']) ?> </p></b></a>
                                    <b><p> Call: <?php echo ($user['phone']) ?></p></b>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="float:right;">
                        <b>Last Visited Date: </b><?= $last_patient->created->format('d F Y') ?>
                    </div>
                    <h4>Patient</h4>
                    <div>
                        <b>Name : </b> <span class="patient_info"><?= ucfirst($prescription->user->first_name)." ".$prescription->user->last_name ?>,</span>
                        <b>Age : </b> <span class="patient_info"><?= $prescription->user->age .' Years' ?>,</span>
                        <b>Mobile : </b> <span class="patient_info"><?= $prescription->user->phone ?></span>
                    </div>
                    <div>
                        <b>Address : </b> <span> <?= ucfirst($prescription->user->address_line1).", ".ucfirst($prescription->user->address_line2) ?> </span>
                    </div>
                    <div>
                        <b>Diagnosis : </b><?= ucfirst($prescription->diagnosis) ?>
                    </div>
                    <div>
                        <b>Temperature : </b><?= $prescription->temperature ?>
                    </div>
                    <div>
                        <b>Blood Pressure : </b><?= ucfirst($prescription->blood_pressure) ?>
                    </div>

                    <div class="prescription_section">
                        <h4>Medicines</h4>
                            <?php
                            foreach ($prescription->medicines as $medicine){
                                echo '<div>
                                        <span class="prescription_caption">'. ucfirst($medicine->name) .' :</span>
                                       '.(($medicine->_joinData->rule)? '<span>'.$medicine->_joinData->rule.'</span>': "-").'
                                    </div>';
                            }
                            ?>
                    </div>

                    <div class="prescription_section">
                        <h4>Tests</h4>
                        <?php
                        foreach ($prescription->tests as $test){
                            echo '<div>
                                    <span class="prescription_caption">'. ucfirst($test->name) .'</span>
                                    '.(($test->_joinData->note)? '<span>( '. $test->_joinData->note .' )</span>':"-").'
                                </div>';
                        }

                        ?>
                    </div>

                    <div>
                        <b>Doctor's Note : </b><?= ucfirst($prescription->doctores_notes) ?>
                    </div>

                    <div class="prescription_footer">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="signature">
                                    <?php $user = $this->request->session()->read('Auth.User'); ?>
                                    <p><b>Signature:</b> <?php echo ($user['signature']) ?> </p>
                                </div>
                            </div>
                            <div class="col-sm-6"></div>
                            <div class="col-sm-3">
                                <div class="date">
                                    <p><b>Date:</b> <?= $prescription->created->format('d F Y'); ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>