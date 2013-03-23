<?php

$xml = '';

try {
    $xml = simplexml_load_file("../hxltools_var/login.xml");

} catch (Exception $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
    echo("Error: Login info incorrect");
}

$nickname = array();
$username = array();
$password = array();

if(empty($xml)) 
{
    echo("Error: Login info not found");
}
else
{
    foreach($xml->children() as $child)
    {
        foreach($child->children() as $child2)
        {
            if ($child2->getName() == 'nickname')
            {
                array_push($nickname, $child2);
            }
            if ($child2->getName() == 'username')
            {
                array_push($username, $child2);
                //$username = $child2;
            }
            if ($child2->getName() == 'password')
            {
                array_push($password, $child2);
                //$password = $child2;
            }
        }
    }
}



?> 

<div id="mask" style="display: none;"></div>
<!--<a href="#login-box" class="login-window">Login / Sign In</a>-->
<div id="login-box" class="login-popup">
    <!--<a href="#" class="close"><img src="img/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>-->
        <form method="post" class="signin" action="#">
            <fieldset class="textbox">
            <label class="username">
            <span>Username</span>
            <input id="username" name="username" value="" type="text" autocomplete="on" placeholder="Username">
            </label>
            <label class="password">
            <span>Password</span>
            <input id="password" name="password" value="" type="password" placeholder="Password">
            </label>
            <button id="login" class="submit button" type="button">Sign in</button>
            <p>
                <br />
                <span id="login_message" class="text-error" style="display: none; color: #b94a48; text-align: center;">Incorrect credentials</span>
            <!--<a class="forgot" href="#">Forgot your password?</a>-->
            </p>        
            </fieldset>
        </form>
</div>