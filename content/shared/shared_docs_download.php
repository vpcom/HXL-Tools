<div class="well" style="max-height:400px; overflow:auto; background:#fff;">
    <ul style="list-style-type: none;"> 
        <?php
            $count = 0;
            $filteredCount = 0;
            $foundInFolder1 = false;
            $foundInFolder2 = false;
            $foundInFolder3 = false;
            $mem0 = '';
            $mem1 = '';
            $mem2 = '';
            $mem3 = '';
            try {
                foreach (new DirectoryIterator(DIR_DOCS) as $file)
                {
                    if($file->isFile())
                    {
                        $filteredCount++;
                    }
                    if(!$file->isDot() &&
                       in_array($file->getExtension(), $filter))
                    {
                        $count++;
                        //print '<li><a target="_blank" href="docs/' . $file->getFilename() . '" style="margin-left:0px;"><i class="icon-download-alt"></i> ' . $file->getFilename() . '</a></li>';
                        $mem0 .= '<li><a target="_blank" href="docs/' . $file->getFilename() . '" style="margin-left:0px;"><i class="icon-download-alt"></i> ' . $file->getFilename() . '</a></li>';
                    }

                    if($file->isDir() &&
                       !$file->isDot())
                    {
                        foreach (new DirectoryIterator(DIR_DOCS . $file) as $sub_file)
                        {
                            if($sub_file->isFile())
                            {
                                $filteredCount++;
                            }
                            if(!$sub_file->isDot() &&
                               in_array($sub_file->getExtension(), $filter))
                            {
                                $count++;
                                //print '<li><a target="_blank" href="docs/' . $file . '/' . $sub_file->getFilename() . '" style="margin-left:20px;"><i class="icon-download-alt"></i> ' . $sub_file->getFilename() . '</a></li>';
                                $mem1 .= '<li><a target="_blank" href="docs/' . $file . '/' . $sub_file->getFilename() . '" style="margin-left:20px;"><i class="icon-download-alt"></i> ' . $sub_file->getFilename() . '</a></li>';
                                $foundInFolder1 = true;
                            }
                            if($sub_file->isDir() &&
                               !$sub_file->isDot())
                            {
                                foreach (new DirectoryIterator(DIR_DOCS . $file . '/' . $sub_file) as $sub2_file)
                                {
                                    if($sub2_file->isFile())
                                    {
                                        $filteredCount++;
                                    }
                                    if(!$sub2_file->isDot() &&
                                       in_array($sub2_file->getExtension(), $filter))
                                    {
                                        $count++;
                                        //print '<li><a target="_blank" href="docs/' . $file . '/' . $sub_file . '/' . $sub2_file->getFilename() . '" style="margin-left:40px;"><i class="icon-download-alt"></i> ' . $sub2_file->getFilename() . '</a></li>';
                                        $mem2 .= '<li><a target="_blank" href="docs/' . $file . '/' . $sub_file . '/' . $sub2_file->getFilename() . '" style="margin-left:40px;"><i class="icon-download-alt"></i> ' . $sub2_file->getFilename() . '</a></li>';
                                        $foundInFolder2 = true;
                                        $foundInFolder1 = true;
                                    }
                                    
                                    if($sub2_file->isDir() &&
                                       !$sub2_file->isDot())
                                    {
                                        foreach (new DirectoryIterator(DIR_DOCS . $file . '/' . $sub_file . '/' . $sub2_file) as $sub3_file)
                                        {
                                            if($sub3_file->isFile())
                                            {
                                                $filteredCount++;
                                            }
                                            if(!$sub3_file->isDot() &&
                                               in_array($sub3_file->getExtension(), $filter))
                                            {
                                                $count++;
                                                //print '<li><a target="_blank" href="docs/' . $sub3_file->getFilename() . '" style="margin-left:60px;"><i class="icon-download-alt"></i> ' . $sub3_file->getFilename() . '</a></li>';
                                                $mem3 .= '<li><a target="_blank" href="docs/' . $sub3_file->getFilename() . '" style="margin-left:60px;"><i class="icon-download-alt"></i> ' . $sub3_file->getFilename() . '</a></li>';
                                                $foundInFolder3 = true;
                                                $foundInFolder2 = true;
                                                $foundInFolder1 = true;
                                            }
                                        }    
                                        if ($foundInFolder3)
                                        {
                                            //print '<li><i class="icon-folder-open" style="margin-left:40px;"></i> ' . $sub2_file->getFilename() . '</li>';
                                            //print $mem3;
                                            $mem2 .= '<li><i class="icon-folder-open" style="margin-left:40px;"></i> ' . $sub2_file->getFilename() . '</li>';
                                            $mem2 .= $mem3;
                                            $mem3 = '';
                                            $foundInFolder3 = false;
                                        }
                                    }
                                }    
                                if ($foundInFolder2)
                                {
                                    //print '<li><i class="icon-folder-open" style="margin-left:20px;"></i> ' . $sub_file->getFilename() . '</li>';
                                    $mem1 .= '<li><i class="icon-folder-open" style="margin-left:20px;"></i> ' . $sub_file->getFilename() . '</li>';
                                    $mem1 .= $mem2;
                                    $mem2 = '';
                                    $foundInFolder2 = false;
                                }   
                            }
                        }   
                        if ($foundInFolder1)
                        {
                            //print '<li><i class="icon-folder-open" style="margin-left:0px;"></i> ' . $file->getFilename() . '</li>';
                            $mem0 .= '<li><i class="icon-folder-open" style="margin-left:0px;"></i> ' . $file->getFilename() . '</li>';
                            $mem0 .= $mem1;
                            $mem1 = '';
                            $foundInFolder1 = false;
                        }  
                    }
                }    
                print $mem0;
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
                echo 'Error: empty directory (' . DIR_DOCS . ').';
            }
        ?>
    </ul>
</div>
<?php
    echo "Found $count files / $filteredCount (extensions:";
    foreach ($filter as $ext)
    {
        echo ".$ext ";
    } 
    echo ").";
?>