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
        var container_value = document.getElementById('container2').value;
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
                if (msg > 0)
                {
                    $('#container_found2').html(msg);
                    $('#container_count_check2').fadeIn(300);
                    $('#del_error2').hide();
                }
                else
                { 
                    $('#del_cont_error2').html('unknown container');
                    $('#del_error2').fadeIn(300);
                    $('#container_count_check2').hide();
                }
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                $('#del_cont_error2').html("Request failed: " + textStatus);
                $('#del_error2').fadeIn(300);
                console.log( "Request failed: " + textStatus );
            }
        );

        request = null;

        return false;
    });

    
    /*
     *
     */
    $('button#del_container2').click(function() 
    {
        var container_value = document.getElementById('container2').value;
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
                if (msg == 1)
                {
                    $('#del_link2').attr('href', '' + container_value);
                    $('#del_success2').fadeIn(300);
                }
                els
                {
                    $('#del_cont_error2').html('an error occured container');
                    $('#del_error2').fadeIn(300);
                    $('#container_count_check2').hide();
                }
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

<span id="del_cont"></span>
<h3>Delete a container</h3>
<p>
    <span class="label label-warning">Warning</span> After completing this procedure the container is unrecoverable.
</p>
    <p>
        Examples:
<div class="well" >
        <ul>
            <li>Uri of the additional locations: <code>http://hxl.humanitarianresponse.info/data/datacontainers/1234567890.111111</code>.</li>
            <li>Uri of the emergencies, organisations and people: <code>http://hxl.humanitarianresponse.info/data/datacontainers/1234567890.500000</code></li>
        </ul>
</div>
    </p>

<h5>1. Test the existence of the container</h5>
<pre class="prettyprint linenums">DROP GRAPH <?php echo htmlspecialchars('<'); ?><form action="" method="get"><input id="container2" type="text" name="container" value="paste://here.your/uri" style="width: 500px;">
<?php echo htmlspecialchars('> '); ?></form>

</pre>                
<button id="check_container" class="btn pull-right execute" type="button">Test <i class="icon-play"></i></button>

<div id="container_count_check2" style="display: none;" >
    <h5>2. Execute the query</h5>
    <div class="well alert-warning" style="padding-right: 0; padding-bottom: 9px;">
        <span id="container_found2"></span> container has been found. Do you want to proceed?
        <button id="del_container2" class="btn btn-warning pull-right" type="button">Delete <i class="icon-play"></i></button>
    </div>
</div>

<div id="del_success2" style="display: none;">
    <h5>3. Check the result by yourself</h5>
    <div class="well">
        The operation occurred and you can check if the container is still here: 
        <div class="btn-group" style="width:100%">
            <a id="del_link2" href="" class="btn" target="_blank" style="position: absolute; bottom: -29px; right: -19px; border-top-left-radius: 4px; border-bottom-left-radius: 4px;">Check <i class="icon-play"></i></a>
        </div>
    </div>
</div>

<div id="del_error2" class="alert alert-block alert-error" style="display: none; padding-right: 0; padding-bottom: 9px;">
    Query returned 0 result: <span id="del_cont_error2"></span>
</div>
<br>
<br>
<br>
