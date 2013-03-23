<?php
/*
 * This file answers AJAX calls 
 */

ini_set('max_execution_time', 600); // [s] to avoid timeout

include_once('../php/sparqllib.php');
include_once('../php/sparqlFunctions.php');

$action = $_POST['action'];
// echo $action;
//if (isset($_POST['container'])) $value = $_POST['container'];
 //echo $value;


switch ($action) {
    case 'check_container':
        $value = $_POST['container'];
        $query = 'PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#>  SELECT (count(*) AS ?count) WHERE { GRAPH ?graph { <' . $value . '> a hxl:DataContainer . } }'; 
        //echo $query;
        $queryResult = getQueryResults($query);
        //echo $queryResult;
        
        while($row = $queryResult->fetch_array())
        {  
            echo $row["count"];
            break;
        } 
        break;

    case 'drop':
        $value = $_POST['container'];
        echo $value;
        $query = ' DROP GRAPH <' . $value . '>'; 
        //echo $query;
        $queryResult = sparqlUpdate($query);
        echo $queryResult;
        break;

    case 'count':
        $value = $_POST['container'];
        $query = 'PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#> SELECT (count(*) AS ?count) WHERE { GRAPH ?graph { ?graph hxl:aboutEmergency ?emergencyUri } ?emergencyUri hxl:commonTitle "' . $value . '" }'; 
        //echo $query;
        $queryResult = getQueryResults($query);

        while( $row = $queryResult->fetch_array() )
        {  

            $temp = $row["count"];

            echo $temp;

            break;
        } 
        break;
        
    case 'countEmePop':
        
        $emergency = $_POST['emergency'];
        $popType = $_POST['popType'];
        $query = 'PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#> SELECT (count(?graph) AS ?count) WHERE { GRAPH ?graph { SELECT DISTINCT ?graph WHERE { GRAPH ?graph { ?graph hxl:aboutEmergency <' . $emergency . '> . ?pop a <' . $popType . '> } } } }'; 
        //echo $query;
        $queryResult = getQueryResults($query);

        while( $row = $queryResult->fetch_array() )
        {  
            echo $row["count"];
            break;
        }
        break;
        
    case 'del_emergency':
        $value = $_POST['container'];
        $query = 'PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#> SELECT ?graph WHERE { GRAPH ?graph { ?graph hxl:aboutEmergency ?emergencyUri } ?emergencyUri hxl:commonTitle "' . $value . '" }'; 
        //echo $query;
        $queryResult = getQueryResults($query);

        if ($queryResult->num_rows() == 0) echo 'false';
        else 
        {
            $count = 0;
            while( $row = $queryResult->fetch_array() )
            {  
                $query = ' DROP GRAPH <' . htmlspecialchars($row["graph"]) . '>'; 
                //echo htmlspecialchars($query);
                sparqlUpdate($query);
                $count++;
            } 
            echo $count;
        }
        break;
        
    case 'del_popType':
        
        $emergency = $_POST['emergency'];
        $popType = $_POST['popType'];

        $query = 'PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#> SELECT ?graph WHERE { GRAPH ?graph { ?graph hxl:aboutEmergency <' . $emergency . '> . ?pop a <' . $popType . '> } }'; 
        
        //echo $query;
        $queryResult = getQueryResults($query);

        if ($queryResult->num_rows() == 0) echo 'false';
        else 
        {
            $count = 0;
            while( $row = $queryResult->fetch_array() )
            {  
                $query = ' DROP GRAPH <' . htmlspecialchars($row["graph"]) . '>'; 
                //echo htmlspecialchars($query);
                sparqlUpdate($query);
                $count++;
            } 
            echo $count;
        }
        break;
}

?>