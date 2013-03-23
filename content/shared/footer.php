<?php

?>

<div class="container footer">
    <div class="row">
        <div class="span5"><strong>Contact</strong><br />
            This site is part of the HumanitarianResponse network. Write to 
            <a href="mailto:info@humanitarianresponse.info">info@humanitarianresponse.info</a> for more information.
        </div>
        <div class="span4"><strong>Updates</strong><br />
            These tools were last updated on <strong><?php  echo date("M d, Y", filemtime('index.php'));  ?> </strong> and initiated by <a href="http://vincentperrin.com">Vincent Perrin</a>.
        </div>
        <div class="span3"><strong>Legal</strong><br />
            Icons courtesy of <a href="http://iconmonstr.com" target="_blank">iconmonstr</a> and <a href="http://thenounproject.com" target="_blank">The Noun Project</a>.<br />
            &copy; 2012 - <?php  echo date("Y", filemtime('index.php'));  ?> UNOCHA.
        </div>
    </div>
</div>