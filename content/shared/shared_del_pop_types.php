<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>


<script>  
    
/* 
 * 
 */
function updateEmeUriField(event) 
{     
    
    console.log("updateEmeUriField" + event);
    console.log("updateEmeUriField" + event.innerHTML);
    
        $('#eme_uri_list_but').html(event.innerHTML);

}


$(document).ready(function()
{
    
    /*
     * Dropdown list update
     */
    $('#del_popType_eme_uri_list').on('click', 'li', function(event)
    {
        event.preventDefault();// prevent the default anchor functionality
    
        $('#mem_eme').html($(this).text());
        $('#del_popType_eme_uri_list_but').html($(this).text() + ' <span class="caret"></span>');
    });
    /*
     * Dropdown list update
     */
    $('#del_eme_pop_list').on('click', 'li', function(event)
    {
        event.preventDefault();// prevent the default anchor functionality
    
        $('#mem_popTypes').html($(this).text());
        $('#del_eme_pop_list_but').html($(this).text() + ' <span class="caret"></span>');
    });
      
    /*
     *
     */
    $('button#del_emePop_count_test').click(function() 
    {
        var eme_value = $('#mem_eme').html();
        var pop_value = $('#mem_popTypes').html();
        
        $('#eme_count_check_pop').hide();
        $('#del_eme_error_pop').hide();
        
        var request = $.ajax
        ({
            url: "ajax/sparql_AJAX.php",
            type: "POST",
            data: {action : 'countEmePop',
                emergency : eme_value,
                popType : pop_value},
            dataType: "html"
        });
        request.done
        (
            function(msg) 
            {   
                //console.log(msg);
                if (msg > 0)
                {
                    $('#container_count_pop').html(msg);
                    $('#eme_count_check_pop').fadeIn(300);
                    $('#del_eme_error_pop').hide();
                    
                }
                else
                { 
                    $('#del_eme_error_msg').html('There is nothing to delete.');
                    $('#del_eme_error_pop').fadeIn(300);
                    $('#eme_count_check_pop').hide();
                }
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                    console.log("eee");
                $('#del_eme_error_msg').html("Request failed: " + textStatus);
                $('#del_eme_error_pop').fadeIn(300);
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
    $('#eme_del_link_pop').click(function() 
    {
        $('#wait4').fadeIn(300);
        var eme_value = $('#mem_eme').html();
        var pop_value = $('#mem_popTypes').html();
        var request = $.ajax
        ({
            url: "ajax/sparql_AJAX.php",
            type: "POST",
            data: {action : 'del_popType',
                emergency : eme_value,
                popType : pop_value},
            dataType: "html"
        });

        request.done
        (
            function(msg) 
            {
                //console.log(msg);
                $('#del_eme_link_pop').attr('href', 'http://sparql.carsten.io/?query=PREFIX%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%20%0ASELECT%20%28count%28%3Fgraph%29%20AS%20%3Fcount%29%20WHERE%20%7B%20GRAPH%20%3Fgraph%20%0A%7B%20%0A%20%20SELECT%20DISTINCT%20%3Fgraph%20WHERE%20%7B%20GRAPH%20%3Fgraph%20%0A%20%20%7B%20%0A%20%20%20%20%3Fgraph%20hxl%3AaboutEmergency%20%3C' + encodeURIComponent(eme_value) + '%3E%20.%20%0A%20%20%20%20%3Fpop%20a%20%3C' + encodeURIComponent(pop_value) + '%3E%20%0A%20%20%7D%7D%0A%7D%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql');
                $('#del_eme_success_pop').fadeIn(300);
                $('#wait4').hide();
            }
        );

        request.fail
        (
            function(jqXHR, textStatus) 
            {
                $('#del_eme_success_pop').hide();
                console.log( "Request failed: " + textStatus );
                alert("Request failed: " + textStatus);
                $('#wait4').hide();
            }
        );

        //console.log(request);
        request = null;

        return false;
    });
});
</script>

<span id="del_popTypes"></span>
<h3>Delete all the populations per type and emergency</h3>
<p>
    <span class="label label-warning">Warning</span> After completing this procedure <b>all the containers</b> related to an emergency will be deleted. Those concerned are defined by the relation:<br>
    <code>?graph hxl:aboutEmergency &LT;URI_OF_EMERGENCY&GT;</code>.<br>
    To recover them use the <a href="#etl_section" >ETL script</a> or the <a href="#ttl_load" >.ttl load script</a> .
</p>
<h5>1. Test the existence of containers</h5>
<pre class="prettyprint linenums">PREFIX hxl: <?php echo htmlspecialchars('<http://hxl.humanitarianresponse.info/ns/#>  '); ?>


SELECT DISTINCT ?graph WHERE {
  GRAPH ?graph {
    ?graph hxl:aboutEmergency &lt;<div class="btn-group" style="width:100%"><button id="del_popType_eme_uri_list_but" data-toggle="dropdown" class="btn dropdown-toggle">Emergency <span class="caret"></span></button><ul id="del_popType_eme_uri_list" class="dropdown-menu"></ul></div>&gt; . 
    ?pop a <?php echo htmlspecialchars('<'); ?><div class="btn-group" style="width:100%"><button id="del_eme_pop_list_but" data-toggle="dropdown" class="btn dropdown-toggle">Population type <span class="caret"></span></button><ul id="del_eme_pop_list" class="dropdown-menu"></ul><?php echo htmlspecialchars('> '); ?></div>
  }
}</pre><button id="del_emePop_count_test" class="btn pull-right execute" type="button">Check <i class="icon-play"></i></button>
<span id="mem_popTypes" style="display:none;"></span>
<span id="mem_eme" style="display:none;"></span>
<!---
<form action="" method="get"><input id="del_ept_eme_field" type="text" name="container" value="http://hxl.humanitarianresponse.info/data/emergencies/mali2012test" style="width: 500px;"></form>
SELECT ?graph WHERE {
  GRAPH ?graph {
    ?graph hxl:aboutEmergency ?emergencyUri 
  }
  ?emergencyUri hxl:commonTitle &quot;<form action="" method="get"><input id="container_eme" type="text" name="emergency" value=""></form>&quot;
}-->
<div id="eme_count_check_pop"  style="display: none;">
    <h5>2. Execute the query</h5>
    <div class="well" style="padding-right: 0; padding-bottom: 8px;">
        Some graphs were found.<br>
        Do you want to perform <span id="container_count_pop"></span> <code>DROP GRAPH &lt;...&gt;</code> to delete the graphs?<br>
        Note that it may take up to 8 minute per 100 containers.<br>
        A timeout can occur defore 150 containerrs. Check and if necessary repeat<br>
        the operation.
        <a id="eme_del_link_pop" href="" class="btn btn-warning" target="_blank" style="float:right; bottom: 0px;">Execute <i class="icon-play"></i></a>
    </div>
</div>
<img src="img/wait.gif" id="wait4" class="center" style="display:none" />

<div id="del_eme_success_pop" style="display: none;">
    <h5>3. Check the result by yourself</h5>
    <div id="del_eme_success_pop" class="well alert-success" style="padding-right: 0; padding-bottom: 9px;">
        The operation occurred and you can check if the container is still here: <a id="del_eme_link_pop" href="" class="btn" target="_blank" style="float:right;">Check <i class="icon-play"></i></a>
    </div>
</div>

<div id="del_eme_error_pop" class="alert alert-block alert-error" style="display: none; padding-right: 0; padding-bottom: 9px;">
    Query returned 0 result: <span id="del_eme_error_msg"></span>
</div>
<br>
<br>
<br>