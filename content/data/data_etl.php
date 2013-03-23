<?php
ini_set('max_execution_time', 600); // [s] to avoid timeout
?>
<script>  
$(document).ready(function()
{
    
    /*
     *
     */
    $('button#check_etl_location_container').click(function() 
    {
        $(".alert").alert();
        var container_value = document.getElementById('container').value;
        var request = $.ajax
        ({
            url: "ajax/sparql_AJAX.php",
            type: "POST",
            data: {action : 'check_container',
                container : container_value},
            dataType: "html"
        });

        request.done
        (
            function(msg) 
            {
                if (msg == 1)
                {
                    $('#container_found').html(msg);
                    $('#container_count_check').fadeIn(300);
                    $('#del_error').hide();
                }
                else
                { 
                    $('#del_cont_error').html('unknown container');
                    $('#del_error').fadeIn(300);
                    $('#container_count_check').hide();
                }
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                $('#del_cont_error').html("Request failed: " + textStatus);
                $('#del_error').fadeIn(300);
                console.log( "Request failed: " + textStatus );
            }
        );

        request = null;

        return false;
    });

    
    
    slice_counter = 0;
    slice_max = 0;
    /*
     *
     */
    $('button#check_container_to_load').click(function() 
    {
        $('#wait3').fadeIn(300);
        
        var slice_size = 100;
        var chosenEmergency = document.getElementById('chosenEmergency').value;
        var request = $.ajax
        ({
            url: "ajax/etl_AJAX.php",
            type: "POST",
            data: {
                action : 'check_containers',
                slice_size : slice_size,
                currentEmergency : chosenEmergency
            },
            dataType: "html"
        });

        request.done
        (
            function(msg, status, xhr) 
            {
                //console.log(msg);
                if (msg > 0)
                {                    
                    var setCount = Math.ceil(msg / slice_size);
            
                    $('#nbr_of_containers').html(msg);
                    $('#nbr_of_slice_display').html(setCount);
                    $('#nbr_of_slice').html(setCount);
                    $('#nbr_of_slice_display').html(setCount);
                    $('#slice_todo').fadeIn(300);
                    $('#del_error').hide();
                    
                    slice_counter++;
                    $('#slice_nbr').html(slice_counter);
                }
                else
                { 
                    if(xhr.getResponseHeader("DB_SUCCESS") == 0){
                        alert("Save failed");
                    }
                    //console.log(msg);
                    $('#del_cont_error').html('unknown container');
                    $('#del_error').fadeIn(300);
                    $('#slice_todo').hide();
                }
                $('#wait3').hide();
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                $('#del_cont_error').html("Request failed: " + textStatus);
                $('#del_error').fadeIn(300);
                console.log( "Request failed: " + textStatus );
                $('#wait3').hide();
            }
        );

        request = null;

        return false;
    });

    
    /*
     *
     */
    $('button#load_slice').click(function() 
    {
        $('#wait3').fadeIn(300);
        var slice_nbr = $('#slice_nbr').html();
        //console.log(nbr_of_slice);
        
        var request = $.ajax
        ({
            url: "ajax/etl_AJAX.php",
            type: "POST",
            data: {
                action : 'load_slice',
                slice_nbr : slice_counter
            },
            dataType: "html"
        });

        request.done
        (
            function(msg) 
            {
                var nbr_of_slice = $('#nbr_of_slice').html();
                if (nbr_of_slice - slice_counter > 0)
                {
                    slice_counter++;
                    $('#slice_nbr').html(slice_counter);
                    $('#wait3').hide();

                    $('#nbr_of_slice_display').html(msg);
                    $('#slice_todo').fadeIn(300);
                    $('#del_error').hide();

                    $('#slice_todo').fadeIn(300);
                }
                else     
                {
                    $('#del_success').fadeIn(300);
                    $('#slice_todo').hide();
                    $('#wait3').hide();
                }
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                console.log( "Request failed: " + textStatus );
                alert("Request failed: " + textStatus);
                $('#wait3').hide();
            }
        );

        request = null;

        return false;
        
    });
});
</script>

<span id="data_etl"></span>
<h3>ETL - refugee data</h3>
<p>
    Load the data directly from the UNHCR database. The db is parsed so as to generate .ttl graphs sent to the triple store via curl with the <code>INSERT DATA</code> command.<br>
    <span class="label label-warning">Warning</span> Make sure <a href="#del_popTypes" >previous emergency containers are deleted</a> and that <a href="#del_loc" >locations already exist</a>.<br>
    <span class="label label-info">Note</span> This procedure can take up to 20 minutes for loading 350 containers.<br>
</p>   
<h5>1. Test the existence of the container</h5>
<div class="well" >
    <a href="#del_popTypes" >Make sure</a> refugee data is not already loaded for the Mali 2012 Emergency.
</div>      
<h5>2. Set your chosen emergency URI</h5>
<div class="well" >
    <input id="chosenEmergency" type="text" value="http://hxl.humanitarianresponse.info/data/emergencies/mali2012test" style="width: 500px;"></input>
</div>      


<h5>3. Check available graphs</h5>
<div class="well" style="padding-right: 0; padding-bottom: 9px;">
    Launch the first step of the script which create ttl graphs. It will tell you how many<br>
    containers can be loaded. It takes about a minute.
    <button id="check_container_to_load" class="btn pull-right" type="button">Check <i class="icon-play"></i></button>
</div>

<span id="nbr_of_slice" style="display: none;" ></span>
<div id="slice_todo" style="display: none;" >
    <h5>4. Execute the query</h5>
    <div class="well" style="padding-right: 0; padding-bottom: 9px;">
        <span id="nbr_of_containers"></span> containers can be loaded gathered in <b><span id="nbr_of_slic_display"></span></b> sets of containers . Do you<br>
        want to proceed?
        <div id="etl_but_group" ></div>
        <span id="etl_load_messsage">Press the button to load the set #</span><span id="slice_nbr"></span>.
        <button id="load_slice" class="btn btn-warning pull-right" type="button">Load group <i class="icon-play"></i></button>
    </div>
</div>
<img src="img/wait.gif" id="wait3" class="center" style="display:none" />

<div id="del_success" style="display: none;">
    <h5>5. Check the result by yourself</h5>
    <div class="alert alert-block alert-success" style="padding-right: 0; padding-bottom: 9px;">
        The operation occurred and <a href="#del_popTypes" >you can check</a> if the containers are still there.
    </div>
</div>

<div id="del_error" class="alert alert-block alert-error" style="display: none; padding-right: 0; padding-bottom: 9px;">
    Query returned 0 result: <span id="del_cont_error"></span>
</div>
<br>
<br>
<br>
