
<?= $this->Form->create($diagnosi,array('id'=>'diagnosisForm')) ?>
<section class="workspace">
    <div class="workspace-body">
        <div class="page-heading">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Diagnosis') ?>">  <?= __('Diagnosis') ?></a></li>
                <li class="active"><a href="#">Add <?= __('Diagnosis') ?></a></li>
            </ol>
        </div>
        <div class="main-container">
            <div class="content">
                <div class="page-wrap">
                    <div class="col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default panel-hovered panel-stacked">
                                    <div class="panel-heading"><?= __('Add Diagnosis') ?></div>
                                    <div class="panel-body">
                                        <?php include('element.ctp'); ?>
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

        jQuery('#diagnosisForm').validate({
            rules:{
                'name': {
                    remote: {
                        url: SITE_URL+'admin/Diagnosis/isDiagnosisAvailable',
                        type: "post",
                        data: {
                            name: function(){ return jQuery("#diagnosisName").val(); }
                        }
                    }
                }
            },
            messages: {
                'name': {
                    remote: 'The Diagnosis already exist.'
                }
            }
        });


    });
</script>

