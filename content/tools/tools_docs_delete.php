<script type="text/javascript">
function deleteFile(fname,rowid,directory)
{
$.ajax(
{ 
    url: "ajax/tools_delete_file.php",
    data: 
    {
        "filename":fname,
        "directory":directory
    },
    type: 'post',
    success: function(output) {
      //alert(output);
      $("#del"+rowid).remove();
    }
});
}
</script>

<span id="docs_delete"></span>
<h3>Delete a file</h3>
<p>
    <span class="label label-warning">Warning</span> Be careful: no confirmation asked, no going back!
</p>
<div class="well" style="max-height:400px; overflow:auto; background:#fff;"> 
    <?php
        $directory  = DIR_DOCS; 
        //$files = scandir($directory);
        $ignore = Array(".htaccess", ".", "..");
        $count=1;
        echo '<table class="table">';
        //foreach($files as $file)
        foreach (new DirectoryIterator(DIR_DOCS) as $file)
        {
                    //echo $file;
            if(!in_array($file->getFilename(), $ignore) &&
               !$file->isDir() )
            {
                echo "<tr id='del$count'><td>$count</td><td>" . '<span style="margin-left:0px;">' . "$file" . '</span>' . "</td><td><input type='button' id='delete$count' value='Delete' onclick='deleteFile(\"$file\",$count,\"$directory\");'></td></tr>";
                $count++;
            }
            if($file->isDir() &&
               !$file->isDot())
            {
                foreach (new DirectoryIterator(DIR_DOCS . $file) as $sub_file)
                {


                    if(!in_array($sub_file->getFilename(), $ignore) &&
                       !$sub_file->isDir())
                    {
                        echo "<tr id='del$count'><td>$count</td><td>" . '<span style="margin-left:20px;">' . "$file/$sub_file" . '</span>' . "</td><td><input type='button' id='delete$count' value='Delete' onclick='deleteFile(\"$sub_file\",$count,\"$directory$file\");'></td></tr>";
                        $count++;
                    }

                    if($sub_file->isDir() &&
                       !$sub_file->isDot())
                    {
                        foreach (new DirectoryIterator(DIR_DOCS . $file . '/' . $sub_file) as $sub_sub_file)
                        {                 
                            if(!in_array($sub_sub_file->getFilename(), $ignore) &&
                               !$sub_sub_file->isDir())
                            {
                                echo "<tr id='del$count'><td>$count</td><td>" . '<span style="margin-left:40px;">' . "$file/$sub_file/$sub_sub_file" . '</span>' . "</td><td><input type='button' id='delete$count' value='Delete' onclick='deleteFile(\"$sub_sub_file\",$count,\"$directory$file/$sub_file\");'></td></tr>";
                                $count++;
                            }

                        }    
                    }
                }    





            }
        }
        echo '</table>';
    ?>
</div>
<br>
<br>
<br>
