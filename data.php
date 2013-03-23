<?php
    $activePage = "data.php";
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
    
            require_once('content/data/data_content.php');

            require_once('content/shared/footer.php');
        ?>
    </body>
</html>