<?php

$filename = $_POST['filename'];
$path = $_POST['directory'];

if(file_exists('../' . $path . "/" . $filename))
{ 
    unlink('../' . $path . "/" . $filename); //deletes file
}

?>