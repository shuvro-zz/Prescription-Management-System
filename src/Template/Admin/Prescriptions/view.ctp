<div class="workspace-dashboard page page-ui-tables">
    <div class="workspace-body">
        <div class="page-heading">
            <div class="flex-container">
                <div class="flex-item">
                    <ol class="breadcrumb breadcrumb-small">
                        <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>"> <?= __('Prescription') ?></a></li>
                        <li class="active"><a href="#">View <?= __('Prescription') ?></a></li>
                    </ol>
                </div>
                <div class="flex-item">
                    <div class="flex-container">
                        <a href="#" class="add-event-btn" id="printButton" title="Print Prescription">Print</a>
                        &nbsp;
                        &nbsp;
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
                    <h4>Patient</h4>
                    <div>
                        <b>Name : </b> <span class="patient_info"><?= $prescription->user->first_name." ".$prescription->user->last_name ?>,</span>
                        <b>Age : </b> <span class="patient_info"><?= $prescription->user->age .' Years' ?>,</span>
                        <b>Mobile : </b> <span class="patient_info"><?= $prescription->user->phone ?></span>
                    </div>
                    <div>
                        <b>Diagnosis : </b><?= $prescription->diagnosis ?>
                    </div>
                    <div>
                        <b>Temperature : </b><?= $prescription->temperature ?>
                    </div>
                    <div>
                        <b>Blood Pressure : </b><?= $prescription->blood_pressure ?>
                    </div>

                    <div class="prescription_section">
                        <h4>Medicines</h4>
                            <?php
                            foreach ($prescription->medicines as $medicine){
                                echo '<div>
                                        <span class="prescription_caption">'. $medicine->name .' :</span>
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
                                    <span class="prescription_caption">'. $test->name .'</span>
                                    '.(($test->_joinData->note)? '<span>( '. $test->_joinData->note.'</span> )':"-").'
                                </div>';
                        }

                        ?>
                    </div>

                    <div>
                        <b>Doctores Note : </b><?= $prescription->doctores_notes ?>
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
                                    <p><b>Date:</b> <?= $prescription->created->format('d/m/Y'); ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>