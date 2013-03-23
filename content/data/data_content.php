<?php
?>
<div class="container start">
<!-- BOOTSTRAP NAV-BAR -->	    
    <div class="row-fluid">
        <div class="span4" style="text-align: center">
            <img src="img/etl_200.png" />
            <div class="navspy">
                <ul class="nav nav-tabs nav-stacked affix-top sidenav" data-spy="affix" data-offset-top="314">
                    <li><a href="#ttl_load">.ttl data<i class="icon-chevron-right pull-right"></i></a></li>
                    <?php if($skipPage !== 'data.php') { ?>
                    <li><a href="#data_etl">(db) ETL - refugee data<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#refd_loc_load">(db) Additional locations<i class="icon-chevron-right pull-right"></i></a></li>
                    <?php } ?>
                    <li><a href="#ref_loc_del">Delete locations<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#del_popTypes">Delete populations per type and emergency<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#del_cont">Delete a container<i class="icon-chevron-right pull-right"></i></a></li>
                    <!--<li><span class="navspy-header"><a href="#ref">General</a></span></li>
                    <li><a href="#oth_load">Load general data<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#oth_del">Delete general data<i class="icon-chevron-right pull-right"></i></a></li>-->
                </ul>		
            </div>	    
        </div>
        <div class="span8">
            <h1>Data</h1>
            <p class="punchline">
                Load and delete data.<br>
                Load or delete using .ttl files, the ETL, and deletion scripts.<br>
                <?php if($skipPage !== 'data.php') { ?>
                    Database available: yes
                <?php } else { ?>
                    Database available: no
                <?php } ?>
            </p>	     	    
            <div id="theContent" style="display: none;">

                <?php 
                    include_once('data_load_ttl.php');
                    if($skipPage !== 'data.php')
                    { 
                        require_once('data_etl.php');
                        require_once('data_refd_loc_load.php');
                    } 
                    require_once('data_ref_loc_del.php');
                    require_once('content/shared/shared_del_pop_types.php');
                    require_once('content/shared/shared_deleteContainer.php'); 
                ?>
<!--
                <h2>IDP data</h2>
                <span id="idp"></span>

<span id="idp_del"></span>
<p>
From UNOCHA.
</p>
<h3>Delete IDP data</h3>
<p>
<span class="label label-warning">Warning!</span> .
</p>
<br>
<br>
<br>
-->

            </div>

        </div>
    </div>
</div> 