<script>  
$(document).ready(function()
{  
    /*
     * Radio buttons
     */
    
    $('.btn-group .btn').on(
        'click', 
        function()
        {
            //var parentID = $(this).parent().attr('id');
            //console.log($(this).html());
            //console.log($('#parentID').html());
            $('input[type=hidden]').val($(this).html());
        }
    );
});
</script>

<span id="docs_upload"></span>
<h3>Upload a file</h3>
<p>
    <span class="label label-warning">Warning</span> No checks are being made on the files, so upload only <b>.rdf</b> or <b>.ttl</b> files. In case of any wrong-doing, use an FTP client to manage the folder directly.<br>
    The less than 100 Ko files are easily handled as well as up to 1 Mo. But be sure to <a href="#docs_delete">delete</a> what you don't need.<br>
    <span class="label label-info">Note</span> The files are uploaded to <b><?php echo DIR_DOCS; ?></b>.<br>
</p>

<?php
if (!empty($_FILES['uploadedfile']['tmp_name']))
{
    $target_path = DIR_DOCS;

    $target_path = $target_path . $_POST['file_path'] . '/' . basename( $_FILES['uploadedfile']['name']); 

    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
        echo "The file ".  basename( $_FILES['uploadedfile']['name']). 
        " has been uploaded";
    } else{
        echo "There was an error uploading the file.";
    }
}
?> 


<h5>1. Select a destination folder</h5>
<div class="well">
    <div class="btn-group" data-toggle="buttons-radio">
        <ul style="list-style-type: none;"> 
            <?php
                try {
                    print '<button type="button" class="btn btn-radio" style="border-radius: 4px;">.</button><br />';
                    foreach (new DirectoryIterator(DIR_DOCS) as $file)
                    {
                        if($file->isDir() &&
                           !$file->isDot())
                        {
                            print '<button type="button" class="btn btn-radio" style="border-radius: 4px; margin-left:20px;">' .  $file->getFilename() . '</button><br />';
                            foreach (new DirectoryIterator(DIR_DOCS . $file) as $sub_file)
                            {
                                if($sub_file->isDir() &&
                                   !$sub_file->isDot())
                                {
                                    print '<button type="button" class="btn btn-radio" style="border-radius: 4px; margin-left:40px;">' . $file . '/' .$sub_file->getFilename() . '</button><br />';
                                    foreach (new DirectoryIterator(DIR_DOCS . $file . '/' . $sub_file) as $sub_sub_file)
                                    {
                                        if($sub_sub_file->isDir() &&
                                           !$sub_sub_file->isDot())
                                        {
                                            print '<button type="button" class="btn btn-radio" style="border-radius: 4px; margin-left:60px;">' . $file . '/' . $sub_file . '/' . $sub_sub_file->getFilename() . '</button><br />';
                                        }
                                    }    
                                }
                            }    
                        }
                    }    
                } catch (Exception $exc) {
                    console.log("error");
                    //echo $exc->getTraceAsString();
                    //echo 'Error: empty directory (' . DIR_DOCS . ').';
                }
            ?>
        </ul>
    </div>
</div>
               
<form enctype="multipart/form-data" action="#" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<h5>2. Choose a file to upload</h5>
<div class="well">
    <input name="uploadedfile" type="file" style="border-radius: 4px;"/>
    <input type="hidden" name="file_path" value=""> 
</div>
<h5>3. Upload</h5>
<div class="well">
    <input class="btn" type="submit" value="Upload File" style="border-radius: 4px;"/>
</div>
</form>
                show success auto disapear
<br>
<br>
<br>
