<div class="workspace-dashboard">
    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4>Dashboard</h4></div>
         
        </div>
    </div>

    <div class="col-md-12">
        <?php echo $this->element('flash_message'); ?>
    </div>

    <div class="dashboard-home-faetures flex-container text-center">
        <div class="dash-box fs_dashboard_area">
                <h1>Search Patient</h1>

            <div class="row">
                <!-- The form -->
                <?php echo $this->Form->create('Prescriptions',[
                    'url' => ['controller' => 'Prescriptions', 'action' => 'searchPatient'],
                    'type' => 'get',
                ]);?>

                <div class="col-sm-offset-4 col-sm-4">
                    <?php echo $this->Form->input('search',array('class' => 'form-control dashboard_search', 'label' => false, 'placeholder' => 'Phone number', 'required' => 'required')); ?>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="add-event-btn">SEARCH</button>
                </div>


                <?php echo $this->Form->end();?>

            </div>

        </div>
    </div>

</div>

