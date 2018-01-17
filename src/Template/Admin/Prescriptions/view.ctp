<div class="workspace-dashboard page page-ui-tables">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>"> <?= __('Prescription') ?></a></li>
                <li class="active"><a href="#">Add <?= __('Prescription') ?></a></li>
            </ol>
        </div>

        <div class="cu_con_outer">
            <div class="cu_con_inner">
                <div class="prescription">
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
                </div>


            </div>
        </div>

    </div>
</div>
