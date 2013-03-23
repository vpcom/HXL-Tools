<div class="container">
    <div class="navbar">
        <div class="container">
            <div class="nav-hxlator">
                <span class="brand" style="padding-top: 0"><img src="img/logo.png"></span>      
                <?php
                    require_once('content/shared/menu.php');
                ?>
            </div>
        </div>
        <a href="#login-box" id="login-link" class="login-window" style="margin: 20px 0px 0px 10px;">Please login</a><span style="float: right; margin-top: 20px;">&nbsp;&nbsp;&nbsp;</span>
        <span id="welcome_phrase" style="display: none; margin: 20px 0px 0px 10px;"></span>
        <a id="logout" href="#" onClick="document.location.reload(true)" style="display: none; margin: 20px 0px 0px 10px;">Logout?</a> 
    </div>    
    <span id="nicknameXml" style="display: none;"><?php foreach ($nickname as &$nick) { echo $nick . ',';} ?></span>
    <span id="usernameXml" style="display: none;"><?php foreach ($username as &$user) { echo $user . ',';} ?></span>
    <span id="passwordXml" style="display: none;"><?php foreach ($password as &$pass) { echo $pass . ',';} ?></span>
</div>