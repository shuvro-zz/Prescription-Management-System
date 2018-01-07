<?php

    /* Plugin Scripts */
    echo $this->Html->script([
        'jquery.min.js',
        'scripts/jquery-validate/jquery.validate.min.js',
    ]);

    /* Custom Scripts */
    echo $this->Html->script([
        'custom/registration.js?v='.$version
    ]);

?>

