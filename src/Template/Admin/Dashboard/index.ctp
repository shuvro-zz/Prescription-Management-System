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
                <h1>Welcome to Patient Management System </h1>
                <span style="color: #000">You can manage your patient easily</span>

            <!-- The form -->
            <div class="search_area">
                <?php echo $this->Form->create('Prescriptions',[
                    'url' => ['controller' => 'Prescriptions', 'action' => 'searchPatient'],
                    'type' => 'get',
                    'class' => 'example'
                ]);?>
                <?php echo $this->Form->input('search',array('class' => 'form-control main-search', 'label' => false, 'placeholder' => 'Type your patient phone number', 'required' => 'required')); ?>
                <button type="submit">SEARCH PATIENT PRESCRIPTION</button>
                <?php echo $this->Form->end();?>
            </div>

        </div>
    </div>

</div>

