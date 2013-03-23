<?php
?>
<div class="container start">	
    <div class="row-fluid">
        <div class="span4" style="text-align: center">
            <img src="img/demo_200.png" />
            <div class="navspy">
                <ul class="nav nav-tabs nav-stacked affix-top sidenav" data-spy="affix" data-offset-top="314">
                    <li><a href="#links_hxl">HXL links<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#links_queries">Query links<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#dow_spr">HXLator Spreadsheets<i class="icon-chevron-right pull-right"></i></a></li>
                </ul>		
            </div>	    
        </div>
        <div class="span8">
            <h1>Demo</h1>
            <p class="punchline">
                All you need for the demo.<br>
                Tested spreadsheets, links, queries.
            </p>	    
            <div id="theContent" style="display: none;">
                <?php 
                    require_once('content/shared/shared_links_hxl.php');
                    require_once('content/shared/shared_links_queries.php');
                    require_once('content/demo/demo_xls_download.php');
                ?>
            </div>
        </div>
    </div>
</div> 