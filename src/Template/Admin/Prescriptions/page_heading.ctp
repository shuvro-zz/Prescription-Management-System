<?php use \Cake\Core\Configure;
use Cake\Routing\Router;
?>
<div class="page-heading">
    <div class="flex-container">
        <div class="flex-item">
            <ol class="breadcrumb breadcrumb-small">
                <li><a href="<?=$this->Url->build(array('action' => 'index' )) ?>" title="<?= __('Prescription') ?>"> <?= __('Prescription') ?></a></li>
                <li class="active"><a  href="#">View <?= __('Prescription') ?></a></li>
            </ol>
        </div>
        <div class="flex-item">
            <div class="flex-container">
                <?php

                    echo $this->Html->link(
                        'Print or Download',
                        ['action' => 'printOrDownload', $prescription->id],
                        ['target' => '_blank', 'class' => 'add-event-btn', 'id' => 'printOrDownload', 'escapeTitle' => false, 'title' => 'Print or Download']
                    );
                    echo '&nbsp;&nbsp;';

                    if(!Configure::read('is_localhost')) {
                        echo $this->Html->link(
                            'Generate pdf',
                            ['action' => 'generatePrescriptionPdf', $prescription->id],
                            ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Generate PDF ']
                        );
                        echo '&nbsp;&nbsp;';

                        $pdf_file_name = $prescription->pdf_file;
                        if ($pdf_file_name != NULL) {
                            echo '<a class="add-event-btn" href=' . $pdf_link . ' title="Download PDF" download> Download Pdf </a>';
                            echo '&nbsp;&nbsp;';

                            if(Configure::read('email_send_allow')) {
                                echo $this->Html->link(
                                    'Send Email',
                                    ['action' => 'sendPrescriptionEmail', $prescription->id],
                                    ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Send Email']
                                );
                                echo '&nbsp;&nbsp;';
                            }
                        }
                    }
                ?>

                <?php
                    /*echo $this->Html->link(
                        'edit prescription',
                        ['action' => 'edit', $prescription->id],
                        ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Edit Prescription']
                    );*/

                    echo $this->Html->link(
                        'Create New',
                        ['controller' => 'dashboard', 'action' => 'index'],
                        ['class' => 'add-event-btn', 'escapeTitle' => false, 'title' => 'Create New']
                    );
                ?>
            </div>
        </div>
    </div>
</div>

<?php if ($is_print == "print"){ ?>
    <script type='text/javascript'>
        $( document ).ready(function() {
            document.getElementById('printOrDownload').click();
        });
    </script>
<?php } ?>