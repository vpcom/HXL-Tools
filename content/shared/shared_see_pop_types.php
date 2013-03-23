<?php
?>
<script>  
$(document).ready(function()
{  
      
    /*
     * Dropdown list update
     */
    $('#pop_list').on('click', 'li', function(event)
    {
        event.preventDefault();// prevent the default anchor functionality
    
        $('#pop_list_but').html($(this).text() + ' <span class="caret"></span>');
        $('#pop_field').attr('value', $(this).text());
        $('#see_pop_btn').attr('href', '' + $(this).text());
        $('#see_pop_btn').show();
    });
      
    /*
    * Click to see the containers of an emergency.
    */
    $('button#see_eme_link').click(function() 
    {
        var emergency_value = encodeURIComponent(document.getElementById('see_eme_uri_field').value);
        window.open('http://sparql.carsten.io/?query=PREFIX%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%20%0ASELECT%20DISTINCT%20*%20WHERE%20%7B%0A%20%20%3Fa%20hxl%3AaboutEmergency%20%3C' + emergency_value + '%3E%20%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql');

        return false;
    });

    /*
    * Click to see the selected populations.
    */
    $('button#see_pop_link').click(function() 
    {
        var emergency_value = encodeURIComponent(document.getElementById('eme_pop_field').value);
        var popType_value = encodeURIComponent(document.getElementById('pop_field').value);
        window.open('http://sparql.carsten.io/?query=PREFIX%20hxl%3A%20%3Chttp%3A//hxl.humanitarianresponse.info/ns/%23%3E%0A%20%0ASELECT%20DISTINCT%20*%20WHERE%20%7B%0A%20%20GRAPH%20%3Fgraph%20%7B%0A%20%20%3Fgraph%20hxl%3AaboutEmergency%20%3C' + emergency_value + '%3E%20.%0A%20%20%3Fpop%20a%20%3C' + popType_value + '%3E%0A%7D%0A%7D&endpoint=http%3A//hxl.humanitarianresponse.info/sparql');

        return false;
    });

});
</script>

<span id="see_pop_type"></span>
<h3>See different types of population</h3>
<h5>1. Select an emergency</h5>
<div class="well">
    <div class="btn-group" style="width:100%">
        <button id="eme_uri_list_but_pop" data-toggle="dropdown" class="btn dropdown-toggle">Emergency <span class="caret"></span></button>
        <ul id="eme_pop_list" class="dropdown-menu">
        </ul>
        <a id="see_eme_pop_btn" href="" class="btn" target="_blank" style="position: absolute; bottom: -19px; right: -19px; border-top-left-radius: 4px; border-bottom-left-radius: 4px;">See it <i class="icon-play"></i></a>
    </div>
</div>
<h5>2. Select a population type</h5>
<div class="well">
    <div class="btn-group" style="width:100%">
        <button id="pop_list_but" data-toggle="dropdown" class="btn dropdown-toggle">Population type <span class="caret"></span></button>
        <ul id="pop_list" class="dropdown-menu">
        </ul>
        <a id="see_pop_btn" href="" class="btn" target="_blank" style="position: absolute; bottom: -19px; right: -19px; border-top-left-radius: 4px; border-bottom-left-radius: 4px;">See definition <i class="icon-play"></i></a>
    </div>
</div>
<h5>3. Launch the query</h5>
<pre class="prettyprint linenums">PREFIX hxl: <?php echo htmlspecialchars('<http://hxl.humanitarianresponse.info/ns/#>'); ?>


SELECT DISTINCT * WHERE {
  GRAPH ?graph {
  ?graph hxl:aboutEmergency <?php echo htmlspecialchars('<'); ?><form action="" method="get"><input id="eme_pop_field" type="text" name="container" value="http://hxl.humanitarianresponse.info/data/emergencies/mali2012test" style="width: 500px;"><?php echo htmlspecialchars('> '); ?></form>
  ?pop a <?php echo htmlspecialchars('<'); ?><form action="" method="get"><input id="pop_field" type="text" name="container" value="http://hxl.humanitarianresponse.info/ns/#RefugeesAsylumSeekers" style="width: 500px;"><?php echo htmlspecialchars('> '); ?></form>
}

</pre><button id="see_pop_link" class="btn pull-right execute" type="button">See populations <i class="icon-play"></i></button>
<br>
<br>
<br>
<br>
