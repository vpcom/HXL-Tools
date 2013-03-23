<?php
?>
<script>  
$(document).ready(function()
{
    
    /*
     * Radio buttons
     */
    $('.btn-group .btn').on(
        'click', 
        function()
        {
            //var parentID = $(this).parent().attr('id');
            //console.log($(this).html());
            $('#load_from_folder').html($(this).html());
            $('#load_ttl_folders').fadeIn(300);
            $('#load_success').hide();
            //$('input[type=hidden]').val($(this).html());
        }
    );
    
    /*
     *
     */
    $('button#load_ref').click(function() 
    {
        $('#wait5').fadeIn(300);
        var request = $.ajax
        ({
            url: "ajax/data_load_unhcr_ttl_AJAX.php",
            type: "POST",
            data: 
            {
                action : 'load',
                path : $('#load_from_folder').html()
            },
            dataType: "html"
        });

        request.done
        (
            function(msg) 
            {          
                //console.log(msg);
                if (msg > 0)
                {
                    $('#load_success').fadeIn(300);
                    $('#wait5').hide();
                    $('#load_error').hide();
                }
                else
                { 
                    $('#load_error_msg').html('unknown or empty emergency' + msg);
                    $('#wait5').hide();
                    $('#load_error').fadeIn(300);
                    $('#load_success').hide();
                }
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                $('#load_error_msg').html("Request failed: " + textStatus);
                $('#load_error').fadeIn(300);
                console.log( "Request failed: " + textStatus );
            }
        );

        //console.log(request);
        request = null;

        return false;
    });
});
</script>

<span id="ttl_load"></span>
<h3>.ttl data</h3>
<p>
    <span class="label label-warning">Note</span> Select a folder that you know and contains one set of .ttl files. Make sure to delete previously existing data before resubmitting it.<br>
    Some data comes from the UNHCR refugee database, some are UNOCHA IDPs. Some are made up for test or demo purpose.
</p>

<h5>1. Check if the data is existing</h5>
<div class="well">
    If you are not sure if the container already exists, use <a href="#del_popTypes">the script for finding populations</a> or <a href="#del_cont">check any container</a> before continuing.
</div>
<h5>2. Select a folder containing .ttl population files</h5>
<div class="well">
    <div class="btn-group" data-toggle="buttons-radio">
        <ul style="list-style-type: none;"> 
            <?php
                try {
                    print '<button type="button" class="btn btn-radio" style="border-radius: 4px;">.</button><br />';
                    foreach (new DirectoryIterator(DIR_DOCS) as $file)
                    {
                        if($file->isDir() &&
                           !$file->isDot())
                        {
                            print '<button type="button" class="btn btn-radio" style="border-radius: 4px; margin-left:20px;">' .  $file->getFilename() . '</button><br />';
                            foreach (new DirectoryIterator(DIR_DOCS . $file) as $sub_file)
                            {
                                if($sub_file->isDir() &&
                                   !$sub_file->isDot())
                                {
                                    print '<button type="button" class="btn btn-radio" style="border-radius: 4px; margin-left:40px;">' . $file . '/' .$sub_file->getFilename() . '</button><br />';
                                    foreach (new DirectoryIterator(DIR_DOCS . $file . '/' . $sub_file) as $sub_sub_file)
                                    {
                                        if($sub_sub_file->isDir() &&
                                           !$sub_sub_file->isDot())
                                        {
                                            print '<button type="button" class="btn btn-radio" style="border-radius: 4px; margin-left:60px;">' . $file . '/' . $sub_file . '/' . $sub_sub_file->getFilename() . '</button><br />';
                                        }
                                    }    
                                }
                            }    
                        }
                    }    
                } catch (Exception $exc) {
                    console.log("error");
                    //echo $exc->getTraceAsString();
                    //echo 'Error: empty directory (' . DIR_DOCS . ').';
                }
            ?>
        </ul>
    </div>
</div>
<span id="load_from_folder" style="display:none;" ></span>

<div id="load_ttl_folders" style="display:none;" >
    <h5>2. Load all the content of the containers</h5>
    <div class="well" style="padding-right: 0; padding-bottom: 9px;">
        Press the button to load all the .ttl files included in this folder.
        <button id="load_ref" class="btn btn-warning pull-right" type="button">Load <i class="icon-play"></i></button>
    </div>
</div>
<img src="img/wait.gif" id="wait5" class="center" style="display:none" />

<div id="load_success" style="display: none;">
    <h5>3. Check the result</h5>
    <div class="well alert-success" style="padding-right: 0; padding-bottom: 9px;">
        The operation occurred<br>
        Please, see <a href="scripts.php#see_pop_type">the population check</a> or use the container URI to check its availability.
    </div>
</div>
<div id="load_error" class="alert alert-block alert-error" style="display: none; padding-right: 0; padding-bottom: 9px;">
    Query returned 0 result: <span id="load_error_msg"></span>
</div>
<br>
<br>
<br>