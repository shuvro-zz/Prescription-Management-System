
<?php

if($presentation_code != 'false'){
    include ('presentation_files.ctp');
} else {

    ?>

    <div class="alert alert-danger hidden" onclick="this.classList.add('hidden');" style="margin-top: 10px;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        <b id="error_msg"></b>
    </div>

    <?php echo $this->Form->create('Pages',array('validate'=>false,'type'=>'post','id'=>'presentation_code', 'url' => ['controller' => 'Pages', 'action' => 'presentation_code'])); ?>

    <label>
        <input type="password" placeholder="Provide your password" name="data[Pages][presentation_code]" >
    </label>

    <input id="code_submit" type="submit" style="margin-top: 10px;">

    <?php echo $this->Form->end(); ?>


<?php } ?>


<script type="text/javascript">
    
    $("#presentation_code").validate({
        rules: {
            'data[Pages][presentation_code]':{
                required:true
            }
        },
        messages: {
            'data[Pages][presentation_code]': "Please enter a valid password."
        },
        errorPlacement: function(error, element) {
            error.insertAfter("#code_submit");
        },
        submitHandler: function(form) {
            $('#code_submit').attr('disabled',true);
            codeSubmit();
        }
    });

    function codeSubmit(){
        var data = $('#presentation_code').serialize();
        $.ajax({
            method:'POST',
            url: SITE_URL + 'pages/presentationCode',
            data:data,
            success:function(response){
                $('#code_submit').attr('disabled',false);
                obj = JSON.parse(response);
                if(obj.status == 'Error'){

                    $('#error_msg').closest('.alert').removeClass('hidden');
                    $('#error_msg').html(obj.msg);

                } else if(obj.status == 'Success'){
                    location.reload();
                }
            }
        });
    }

</script>
