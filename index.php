<!DOCTYPE html>
<html lang="en">
    <?php 
        require_once('content/shared/head.php');
        require_once('php/init.php');
        require_once('php/testdb.php');
    ?>
    <body>
    <?php 
        include_once('php/loginPopup.php');
    ?>
	<div class="container">
		<div class="navbar">
            <div class="container">
                <div class="nav-hxlator">
                    <span class="brand" style="padding-top: 0"><img src="img/logo.png"></span>  
                </div>
            </div>
            <a href="#login-box" id="login-link" class="login-window" style="margin: 20px 0px 0px 10px;">Please login</a><span style="float: right; margin-top: 20px;">&nbsp;&nbsp;&nbsp;</span>
            <span id="welcome_phrase" style="display: none; margin: 20px 0px 0px 10px;"></span>
            <a id="logout" href="#" onClick="document.location.reload(true)" style="display: none; margin: 20px 0px 0px 10px;">Logout?</a> 
	    </div>  
        <span id="nicknameXml" style="display: none;"><?php foreach ($nickname as &$nick) { echo $nick . ',';} ?></span>
        <span id="usernameXml" style="display: none;"><?php foreach ($username as &$user) { echo $user . ',';} ?></span>
        <span id="passwordXml" style="display: none;"><?php foreach ($password as &$pass) { echo $pass . ',';} ?></span>
	    <div class="container start">	    
	    	<div class="row">
		     	<div class="span4" style="text-align: center">
		    		<img src="img/scripts_200.png" />
		      	</div> 
		      	<div class="span8">
		      		<h1 class="headline">HXL tools</h1>
			        <p class="punchline">
                        Everything you need to demo, manage and query the data, and to get on the project.<br>
                    </p>	     
		      	</div>
		  	</div>
	        <div class="row">
	          <div class="span1">
	        	<h2><a href="demo.php"><img src="img/demo_60.png" /></a></h2>
	          </div>
		      <div class="span2">
		        <h2><a href="demo.php">Demo</a></h2>
		      </div>
		      <div class="span1">
	        	<h2><a href="data.php"><img src="img/etl_60.png" /></a></h2>
	          </div>
		      <div class="span2">
		        <h2><a href="data.php">Data</a></h2>
              </div>                
		      <div class="span1">
	        	<h2><a href="scripts.php"><img src="img/scripts_60.png" /></a></h2>
	          </div>
		      <div class="span2">
		        <h2><a href="scripts.php">Scripts</a></h2>
		      </div>
		      <div class="span1">
	        	<h2><a href="tools.php"><img src="img/tools_60.png" /></a></h2>
	          </div>
		      <div class="span2">
		        <h2><a href="tools.php">Tools</a></h2>
		      </div>
		    </div>
		    <div class="row">
		    	<div class="span3">
		      		<p>
                        All for the demo:
                        <ul>
                            <li>Tested spreadsheets</li>
                            <li>Links</li>
                            <li>Queries</li>
                        </ul>
                    </p>
		      	</div>
		      	<div class="span3">
		      		<p>
                        Load and delete data with:
                        <ul>
                            <li>.ttl files</li>
                            <li>ETL</li>
                            <li>deletion scripts</li>
                        </ul>
                    </p>
		      	</div>
		      	<div class="span3">
		      		<p>
                        Useful scripts and queries.
                    </p>
		      	</div>
		      	<div class="span3">
		      		<p>
                        The developer's guide to HXL:
                        <ul>
                            <li>Doc managements</li>
                            <li>Install guide</li>
                            <li>Links</li>
                        </ul>
                    </p>
		      	</div>
		    </div>
	    </div>	   
	</div> <!-- /container -->
        <?php
            require_once('content/shared/footer.php');
        ?>
  </body>
</html>