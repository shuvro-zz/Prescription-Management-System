
<?= $this->Form->create($user, array('id' => 'userForm')) ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <?php if($this->request->session()->read('Auth.User.role_id') == 1){ ?>
                    <li><a href="<?=$this->Url->build(array('action' => 'index/2' )) ?>" title="<?= __('Doctor') ?>"> <?= __('Doctor') ?></a></li>
                    <li class="active"><a href="#">Add <?= __('Doctor') ?></a></li>
                <?php }else{ ?>
                    <li><a href="<?=$this->Url->build(array('action' => 'index/3' )) ?>" title="<?= __('Patient') ?>"> <?= __('Patient') ?></a></li>
                    <li class="active"><a href="#">Add <?= __('Patient') ?></a></li>
                <?php } ?>
            </ol>
        </div>
        <div class="main-container">
            <div class="content">
                <div class="page-wrap">
                    <div class="col-sm-12 col-md-12">
                        <?php echo $this->Flash->render('admin_success'); ?>
                        <?php echo $this->Flash->render('admin_error'); ?>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-heading"><?= __('Add Patient') ?></div>
                                    <?php echo $this->element('patient_element') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <footer class="footer ">
        <div class="flex-container">
            <a href="<?php echo $this->Url->build(array('action' => 'index' )) ?>" class="btn btn-default  btn-cancel" title="Cancel">Cancel</a>
            <div class="flex-item">
                <?= $this->Form->button(__('Submit'), ['class' => 'btn save event-save']) ?>
            </div>
        </div>
    </footer>

</section>
<?= $this->Form->end() ?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        //alert(SITE_URL+'admin/tests/is_test_available');

        jQuery('#userForm').validate({
            rules:{
                'phone': {
                    remote: {
                        url: SITE_URL+'admin/Users/isUserAvailable',
                        type: "post",
                        data: {
                            phone: function(){ return jQuery("#userPhone").val(); }
                        }
                    }
                }
            },
            messages: {
                'phone': {
                    remote: 'The Patient already exist.'
                }
            }
        });


    });
</script>
