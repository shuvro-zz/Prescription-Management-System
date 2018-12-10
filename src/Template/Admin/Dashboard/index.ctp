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

            <!-- The form -->
            <div class="search_area">
                <?php echo $this->Form->create('Prescriptions',[
                    'url' => ['controller' => 'Prescriptions', 'action' => 'searchPatient'],
                    'type' => 'get',
                    'class' => 'example'
                ]);?>
                <?php echo $this->Form->input('search',array('class' => 'form-control main-search', 'label' => false, 'placeholder' => 'Phone number', 'required' => 'required')); ?>
                <button type="submit" class="add-event-btn">SEARCH</button>
                <?php echo $this->Form->end();?>
            </div>

        </div>
    </div>

</div>

