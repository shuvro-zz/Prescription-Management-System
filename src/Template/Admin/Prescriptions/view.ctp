<div class="workspace-dashboard page page-ui-tables">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>"> <?= __('Prescription') ?></a></li>
                <li class="active"><a href="#">View <?= __('Prescription') ?></a></li>
            </ol>
        </div>

        <div class="cu_con_outer">
            <div class="cu_con_inner">
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
                    <p>
                        <b>Name: </b> <span class="patient_info"><?= $prescription->user->first_name." ".$prescription->user->last_name ?>,</span>
                        <b>Age: </b> <span class="patient_info"><?= $prescription->user->age .' Years' ?>,</span>
                        <b>Mobile: </b> <span class="patient_info"><?= $prescription->user->phone ?></span>
                    </p>
                    <p>
                        <b>Diagnosis: </b><?= $prescription->diagnosis ?>
                    </p>

                    <h4>Tests</h4>
                    <p>
                        <?php
                            foreach ($prescription->tests as $tests){
                                if ($tests === end($prescription->tests)){
                                    echo '<span class="test_name">'. $tests->name .' </span>';
                                }else{
                                    echo '<span class="test_name">'. $tests->name .', </span>';
                                }
                            }
                        ?>
                    </p>

                    <h4>Medicines</h4>
                    <p>
                        <?php
                        foreach ($prescription->medicines as $medicines){
                            if($medicines === end($prescription->medicines)){
                                echo '<span class="medicines_name">'. $medicines->name .'</span>';
                            }else{
                                echo '<span class="medicines_name">'. $medicines->name .', </span>';
                            }
                        }
                        ?>
                    </p>
                    <div class="prescription_fotter">
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
                                    <p> <?= $prescription->created ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>
