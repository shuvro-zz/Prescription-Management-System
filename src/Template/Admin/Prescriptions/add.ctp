
<?= $this->Form->create($prescription,['id' => 'prescription-form']) ?>
<section class="workspace work_section">
    <div class="workspace-body work_body_section">

        <?php /*pr($this->name); die; */?>
        <div class="main-container main_container_section">
            <div class="content prescription_content    ">
                <div class="col-md-12">
                    <?php echo $this->Flash->render('admin_success'); ?>
                    <?php echo $this->Flash->render('admin_error'); ?>
                    <?php echo $this->Flash->render('admin_warning'); ?>
                </div>

                <?php include('element.ctp'); ?>

            </div>
        </div>
    </div>

</section>
<?= $this->Form->end() ?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#prescription-form').validate({
            rules:{
                "patients[phone]": {
                    remote: {
                        url: SITE_URL+'admin/Prescriptions/isMobileAvailable',
                        type: "post",
                        data: {
                            phone: function(){ return jQuery("#user-phone").val(); }
                        }
                    }
                }
            },
            messages: {
                "patients[phone]": {
                    remote: 'The mobile number already exist.'
                }
            }
        });
    });
</script>