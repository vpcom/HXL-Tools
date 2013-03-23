<ul class="nav" id="topnav" >           
    <?php
    //global $skipPage;
    $links = array("index.php" => "Home", 
                   "demo.php" => "Demo", 
                   "data.php" => "Data", 
                   "scripts.php" => "Scripts", 
                   "tools.php" => "Tools"); 

    foreach($links as $link => $text)
    {
        /*if($link === $skipPage)
        {
            continue;
        }
        else 
        */
        if($link === $activePage)
        {
            echo'<li class="active"><a href="'.$link.'">'.$text.'</a></li>';
        }
        else if($link === 'index.php')
        {
            echo'<li><a href="'.$link.'"><img src="img/home.png" /></a></li>';
        }
        else
        {
            echo'<li><a href="'.$link.'">'.$text.'</a></li>';	
        }
    }
    ?>
</ul>