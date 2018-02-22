
<?= $this->Form->create($test,array('id'=>'testForm')) ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Test') ?>"> <?= __('Test') ?></a></li>
                <li class="active"><a href="#">Add <?= __('Test') ?></a></li>
            </ol>
        </div>
        <div class="main-container">
            <div class="content">
                <div class="page-wrap">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-heading"><?= __('Add Test') ?></div>
                                    <div class="panel-body">
                                         <div class="col-sm-6">
                                            <div class="form-row">
                                                <label class="name">Name<span class="required" aria-required="true"></span></label>
                                                <div class="inputs">
                                                   <?php echo $this->Form->input('name', ['class' => 'form-control','id'=>'testName', 'label' => false, 'required' => true, 'type' =>'text']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

        jQuery('#testForm').validate({
            rules:{
                'name': {
                    remote: {
                        url: SITE_URL+'admin/Tests/isTestAvailable',
                        type: "post",
                        data: {
                            name: function(){ return jQuery("#testName").val(); }
                        }
                    }
                }
            },
            messages: {
                'name': {
                    remote: 'The Test already exist.'
                }
            }
        });


    });
</script>
