
<?php

// todo message notifying tis status on the data page



$skipPage = "";

function handleError($errno, $errstr, $errfile, $errline, array $errcontext)
{
    global $skipPage;
    $skipPage = "data.php";
}
set_error_handler('handleError');



try {
    
    $mysqli = new mysqli($sourceConfig['db_host'], $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);
    //$mysqli = new mysqli('gg', $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);
    if ($mysqli->connect_error) {
$skipPage = "data.php";
    }
    
} catch (Exception $exc) {
$skipPage = "data.php";
}

?>
