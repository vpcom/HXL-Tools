<?php
?>
<div class="container start">
<!-- BOOTSTRAP NAV-BAR -->	    
    <div class="row-fluid">
        <div class="span4" style="text-align: center">
            <img src="img/scripts_200.png" />
            <div class="navspy">
                <ul class="nav nav-tabs nav-stacked affix-top sidenav" data-spy="affix" data-offset-top="314">
                    <li><a href="#see_eme">See the containers of an emergency <i class="icon-chevron-right pull-right"></i></a></li>
                    <!--
                    <li><a href="#mod_triple">Modify a triple <i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#del_triple">Delete a triple <i class="icon-chevron-right pull-right"></i></a></li>
                    -->
                    <li><a href="#see_pop_type">See different types of population<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#del_cont">Delete a container<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#del_popTypes">Delete all the populations per type and emergency<i class="icon-chevron-right pull-right"></i></a></li>
                </ul>		
            </div>	    
        </div>
        <div class="span8">
            <h1>Scripts</h1>
            <p class="punchline">Useful scripts and queries</p>	     	    
            <div id="theContent" style="display: none;">
                <?php 
                    require_once('content/shared/shared_see_emergency.php');
                    require_once('content/shared/shared_see_pop_types.php');
                    require_once('content/shared/shared_deleteContainer.php'); 
                    require_once('content/shared/shared_del_pop_types.php');
                ?>
            </div>
        </div>
    </div>
</div> 