<?php
?>


<script>  
$(document).ready(function()
{
    
    /*
     *
     */
    $('button#check_container').click(function() 
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

        //console.log(request);
        request = null;

        return false;
    });

    
    /*
     *
     */
    $('button#del_container').click(function() 
    {
        $(".alert").alert();
            //console.log("-------" + document.getElementById('container').value);
        var container_value = document.getElementById('container').value;
        var request = $.ajax
        ({
            url: "ajax/sparql_AJAX.php",
            type: "POST",
            data: {action : 'drop',
                container : container_value},
            dataType: "html"
        });

        request.done
        (
            function(msg) 
            {
                /* check that */
                $('#del_link').attr('href', '' + container_value);
                $('#del_success').fadeIn(300);
                
                $('#container_found').html(msg);
                $('#container_count_check').fadeIn(300);
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                console.log( "Request failed: " + textStatus );
                alert("Request failed: " + textStatus);
            }
        );

        //console.log(request);
        request = null;

        return false;
    });
});
</script>

<span id="ref_loc_del"></span>
<h3>Delete locations</h3>
<p>
    <span class="label label-warning">Warning</span> During this procedure the container will be deleted. They are necessary for the ETL and for the Dashboard to get the information according existing locations. To recover them, just <a href="#loc_creator" >load locations</a> section. <br>
</p>

<h5>1. Test the existence of the container</h5>
<pre class="prettyprint linenums">DROP GRAPH <?php echo htmlspecialchars('<'); ?><form action="" method="get"><input id="container" type="text" name="container" value="http://hxl.humanitarianresponse.info/data/datacontainers/1234567890.111111" style="width: 500px;">
<?php echo htmlspecialchars('> '); ?></form>

</pre>                
<button id="check_container" class="btn pull-right execute" type="button">Test existence <i class="icon-play"></i></button>

<div id="container_count_check" style="display: none;" >
    <h5>2.Execute the query</h5>
    <div class="well" style="padding-right: 0; padding-bottom: 9px;">
        <span id="container_found"></span> container has been found. Do you want to proceed?
        <button id="del_container" class="btn btn-warning pull-right" type="button">Delete <i class="icon-play"></i></button>
    </div>
</div>

<div id="del_success" style="display: none;">
    <h5>3.Check the result by yourself</h5>
    <div class="well" style="padding-right: 0; padding-bottom: 9px;">
        The operation occurred and you can check if the container is still here. <a id="del_link" href="" class="btn btn-success" target="_blank" style="float:right">Check <i class="icon-play"></i></a>
    </div>
</div>

<div id="del_error" class="alert alert-block alert-error" style="display: none; padding-right: 0; padding-bottom: 9px;">
    Query returned 0 result: <span id="del_cont_error"></span>
</div>
<br>
<br>
<br>
