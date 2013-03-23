<?php
/*
 * This file answers AJAX calls 
 */
try {
session_start();
ini_set('max_execution_time', 600); // [s] to avoid timeout

require_once('../php/etl_functions.php');
require_once('../php/init_AJAX.php');

/*
$log = new Logging();
$log->file($logETL);
*/

$action = $_POST['action'];
 //echo $action;

switch ($action) {
    case 'check_containers':
        
        $sliceSize = $_POST['slice_size']; 
        $currentEmergency = $_POST['currentEmergency']; 

        $_SESSION['slice_size'] = $sliceSize;
        
        $mysqli = new mysqli($sourceConfig['db_host'], $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);
        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        // Checking the content
        if ($dbContent = $mysqli->query($mysqlQueryAllRows)) //$mysqlQueryAllRows // $mysqlQueryManyRows
        {
            $dropScript = '';
            $sparqlQueryArray = array();
            $count = 0;

            $sourceTranslation = translateSources();

            while($dbRow = mysqli_fetch_array($dbContent))
            {
                //if ($count == 10) break;
                $count++;
                $query =  '';

                // echo $dbRow['source'];
                if (isRowOk($dbRow))
                {
                    $containerInfo = extractRowData($dbRow, $sourceTranslation, $currentEmergency);
                    //echo "<br>";
                    //echo $containerInfo[0][0];
                    $query = htmlspecialchars_decode($ttlPrefixes) . ' INSERT DATA { GRAPH <' . $containerInfo[0][0] . '> { ' . $containerInfo[1][0] . '}}';

                    array_push($sparqlQueryArray, $query);

                    $dropScript .= $containerInfo[2];
                }
                else
                {
                    //$log->write("Row not matching to a location or not containing interesting data.");
                    //echo("Row not matching to a location or not containing interesting data.");
                }
            }

            // return the number of containers to be loaded
            $rowCount = count($sparqlQueryArray);
            echo $rowCount;

            $splitCount = ceil($rowCount / $sliceSize);
            $_SESSION['splitCount'] = $splitCount;

            // The data is sent to the session for the following steps
            $_SESSION['sparqlQueryArray'] = serialize($sparqlQueryArray);
/*
            // Link to access the following steps
            echo "There are $splitCount chunks of database to parse.<br />";
            echo "Are you ready to proceed with the first slice?<br />";
            echo "<a href=?slice=1>Click here</a><br />";
            echo '<br />';
            */
            //echo json_encode($sparqlQueryArray);
            exit; 
        }
        else
        {
            //$log->write("Data base connection error: $mysqli->error");
            echo("Data base connection error: $mysqli->error");
            //$log->close();  
        }
        
        break;

    case 'load_slice':
        
        $slice = $_POST['slice_nbr']; 
        $sliceSize = $_SESSION['slice_size']; 

        $sparqlQueryArray = unserialize($_SESSION['sparqlQueryArray']);
        $splitCount = $_SESSION['splitCount'];

        $splittedQueryArray = array_chunk($sparqlQueryArray, $sliceSize);
/*
        if (count($splittedQueryArray) != $slice)
        {
            echo "There are $splitCount chunks of database to parse.<br />";
            echo "Are you ready to proceed with the next slice?<br />";
            echo "<a href=?slice=" . (intval($slice) + 1.0) . ">Click here for the slice number " . (intval($slice) + 1.0) . "</a><br />";
            echo '<br />';
        }
*/
        $errorCount = 0;
        $successCount = 0;

        for($k = 0; $k < $sliceSize; $k++)
        {
            if (!array_key_exists($k, $splittedQueryArray[$slice - 1])) break;

            //echo htmlspecialchars($splittedQueryArray[$slice - 1][$k]);
    
            if (!sparqlUpdate($splittedQueryArray[$slice - 1][$k]))
            {
                $errorCount++;
            }
            else
            {
                $successCount++;
            }
            
            //echo ' - ' . $successCount . ' - ';
        }
        break;
    }
}
catch (Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>