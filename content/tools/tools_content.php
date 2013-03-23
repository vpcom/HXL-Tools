<?php
?>
<div class="container start">
    <!-- BOOTSTRAP NAV-BAR -->    
    <div class="row-fluid">
        <div class="span4" style="text-align: center">
            <img src="img/tools_200.png" />
            <div class="navspy">
                <ul class="nav nav-tabs nav-stacked affix-top sidenav" data-spy="affix" data-offset-top="314">
                    <li><span class="navspy-header"><a href="#docs_mgmt">Doc management</a></span></li>
                    <li><a href="#docs_download">Download a file <i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#docs_upload">Upload a file <i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#docs_delete">Delete a file <i class="icon-chevron-right pull-right"></i></a></li>
                    <li><span class="navspy-header"><a href="#install_guide">Install guide</a></span></li>
                    <!--<li><a href="#install_hxltools">How to install HXL Tools <i class="icon-chevron-right pull-right"></i></a></li>-->
                    <li><a href="#raptor">Raptor - TTL 2 RDF on Windows <i class="icon-chevron-right pull-right"></i></a></li>
                    <li><span class="navspy-header"><a href="#links">Links</a></span></li>
                    <li><a href="#links_hxl">HXL links <i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#links_queries">Query links<i class="icon-chevron-right pull-right"></i></a></li>
                    <li><a href="#links_others">Technical resources <i class="icon-chevron-right pull-right"></i></a></li>
                </ul>		
            </div>	    
        </div>
        <div class="span8">
            <h1>Tools</h1>
            <p class="punchline">
                The developer's guide to HXL.<br>
                Doc management, install guide and links.
            </p>	     	    
            <div id="theContent" style="display: none;">
                    <h2>Doc management</h2>
                    <span id="docs_mgmt"></span>
                <?php 
                    require_once('content/tools/tools_docs_download.php');
                    require_once('content/tools/tools_docs_upload.php');
                    require_once('content/tools/tools_docs_delete.php');
                ?>
                    <h2>Install guide</h2>
                    <span id="install_guide"></span>

                <?php 
                    //require_once('content/tools/tools_install_hxltools.php');
                    require_once('content/tools/tools_raptor.php');
                ?>
                    <h2>Links</h2>
                    <span id="links"></span>
                <?php 
                    require_once('content/shared/shared_links_hxl.php');
                    require_once('content/shared/shared_links_queries.php');
                    require_once('content/tools/tools_links_others.php');
                ?>
            </div>
        </div>
    </div>
</div> 