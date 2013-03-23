<?php
?>
<script>  
$(document).ready(function()
{
    
    /*
     *
     */
    $('button#create_loc_check_container').click(function() 
    {
        //$(".alert").alert();
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
                if (msg == 0)
                {
                    $('#create_loc_container_count_check').fadeIn(300);
                    $('#createLocation_error').hide();
                }
                else
                { 
                    $('#createLocation_error_msg').html('already existing container');
                    $('#createLocation_error').fadeIn(300);
                    $('#create_loc_container_count_check').hide();
                }
                
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                $('#createLocation_error_msg').html("Request failed: " + textStatus);
                $('#createLocation_error').fadeIn(300);
                console.log( "Request failed: " + textStatus );
            }
        );

        //console.log(request);
        request = null;

        return false;
    });

    
    /*
     *
     */
    $('button#create_locations').click(function() 
    {
        //console.log('jfhhfhfhfhfhfh');
       //$(".alert").alert();
        $('#wait2').fadeIn(300);
        var container_value = document.getElementById('container').value;
        var request = $.ajax
        ({
            url: "ajax/createLocation_AJAX.php",
            type: "POST",
            data: {action : 'check_container',
                container : container_value},
            dataType: "html"
        });

        request.done
        (
            function(msg) 
            {
                if (msg > -1)
                {
        console.log('else' + msg + '-');
                    //$('#container_found').html(msg);
                    $('#createLocation_success').fadeIn(300);
                    $('#createLocation_error').hide();
                }
                else
                { 
        console.log('-1' + msg + '-');
                    $('#createLocation_error_msg').html('unknown container');
                    $('#createLocation_error').fadeIn(300);
                    $('#createLocation_success').hide();
                }
                $('#wait2').hide();
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
        //console.log('fail');
                $('#createLocation_error_msg').html("Request failed: " + textStatus);
                $('#createLocation_error').fadeIn(300);
                console.log( "Request failed: " + textStatus );
                $('#wait2').hide();
            }
        );

        //console.log(request);
        request = null;

        return false;
    });
});
</script>

<span id="refd_loc_load"></span>
<h3>Load locations</h3>
<p><span class="label label-info">Note</span> Make sure the data doesn't already exist before launching this script.</p>
<p>
    This script uses the <code>unhcretl</code> database to create the container <code>http://hxl.humanitarianresponse.info/data/datacontainers/1234567890.111111</code> containing all the necessary APL and locations to allow the data to be found when querying per location.<br>
    This set of data is a temporary solution aimed at using UNHCR data with the HXL project.
</p>
            
<h5>1. Test the existence of the container</h5>
<pre class="prettyprint linenums">DROP GRAPH <?php echo htmlspecialchars('<'); ?><form action="" method="get"><input id="container" type="text" name="container" value="http://hxl.humanitarianresponse.info/data/datacontainers/1234567890.111111" style="width: 500px;">
<?php echo htmlspecialchars('> '); ?></form>

</pre>                
<button id="create_loc_check_container" class="btn pull-right execute" type="button">Test existence <i class="icon-play"></i></button>

<div id="create_loc_container_count_check" style="display: none;" >
    <h5>2.Execute the query</h5>
    <div class="well" style="padding-right: 0; padding-bottom: 9px;">
        The container doesn't already exists. Do you want to create it?
        <button id="create_locations" class="btn btn-warning pull-right" type="button">Create locations <i class="icon-play"></i></button>
    </div>
    <img src="img/wait.gif" id="wait2" class="center" style="display:none" />
</div>

<div id="createLocation_success" style="display: none;">
    <h5>3. Check the result by yourself</h5>
    <div class="well" style="padding-right: 0; padding-bottom: 9px;">
        (url) The operation occurred and you can check how the container looks like: <a id="del_link" href="http://hxl.humanitarianresponse.info/data/datacontainers/1234567890.111111" class="btn btn-success" target="_blank" style="float:right">Check <i class="icon-play"></i></a>
    </div>
</div>

<div id="createLocation_error" class="alert alert-block alert-error" style="display: none; padding-right: 0; padding-bottom: 9px;">
    Query returned 0 result: <span id="createLocation_error_msg"></span>
</div>
<!--<br>
<br>
<br>
-->