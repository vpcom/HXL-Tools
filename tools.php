<?php
    $activePage = "tools.php";
?>
<!DOCTYPE html>
<html lang="en">
    <?php 
        require_once('content/shared/head.php');
    ?>
    <body data-spy="scroll" data-target=".navspy" onload="prettyPrint()">
        <?php
            require_once('php/init.php');
            require_once('php/loginPopup.php');
            require_once('php/testdb.php');

            require_once('content/shared/page_top.php');
   
            require_once('content/tools/tools_content.php');
            
            require_once('content/shared/footer.php');
        ?>
        <script>
        
  
$(document).ready(function()
{  
    /*
     * Dropdown list update
     *
   
        $('input[type=file]').change(function() {
    $(this).upload('docs/', function(res) {
        alert('File uploaded');
    }, 'json');
});

    /*
     * Dropdown list update
     */
    $('#upload_button').click(function(event)
    {
        console.log("ddddddddddd");
    });
});
</script>

    </body>
</html>