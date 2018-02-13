<div class="workspace-dashboard">
    <div class="page-heading">
        <div class="flex-container">
            <div class="flex-item"><h4>Dashboard</h4></div>
         
        </div>
    </div>

    <div class="col-md-12">
        <?php echo $this->element('flash_message'); ?>
    </div>

    <div class="dashboard-home-faetures flex-container">
        <div class="dash-box">
            <div class="feature-box">
                <h2>Welcome to Patient Management System </h2>
            </div>
        </div>
    </div>


    <div class="event-listing">
        <div class="event-listing-top flex-container status-function">
            <div class="status-area flex-container">
                <div class="event-src-box">
                <?php echo $this->Form->create('Prescriptions',[
                    'url' => ['controller' => 'Prescriptions', 'action' => 'searchPatient'],
                    'type' => 'get'
                ]);?>
                    <?php echo $this->Form->input('search',array('class' => 'form-control', 'label' => false, 'placeholder' => 'Type phone no', 'required' => 'required')); ?>
                    <button type="submit"> <i class="fa fa-search"></i></button>
                <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>