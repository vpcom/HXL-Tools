<?php

/* Performs an update query to the triple store.
 * Used for inserting and deleting.
 */

function sparqlUpdate($query)
{
    //global $store_username, $store_password, $store_endpoint;
// Login to access the triplestore
$store_username = '257e';

// Password to access the triplestore
$store_password = '2rSBs5GTga';

// End point to access the triplestore
$store_endpoint = 'http://hxl.humanitarianresponse.info/update';

    
    try 
    {
        $parameterString = "update=" . $query;//. urlencode( $query );   

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, $store_username . ':' . $store_password);
        curl_setopt($ch, CURLOPT_URL, $store_endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parameterString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        // doesn t work (with Fuseki !?) => no accents... curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8'); 

        
        $response = curl_exec($ch);
/*
        echo('<br>');
        echo('$query: ' . htmlspecialchars($query));
        echo('<br>');
        echo($response);
        echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo('<br>');
        */
        
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200)
        {
            //$log->write("Update: success" . curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
            //echo true;
/*
        echo('<br>');
        echo('$query: ' . htmlspecialchars($query));
        echo('<br>');
        echo($response);
        echo curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo('<br>');
        */
            return true;
        }
        else
        {
            //$log->write("Update  FAILED: " . curl_getinfo($ch, CURLINFO_CONTENT_TYPE));

        echo('<pre>Failed: ');
        echo(curl_getinfo($ch, CURLINFO_CONTENT_TYPE));
        echo($response);
        echo('</pre>');
        
            /*
            print_r('<pre>');
            echo(htmlspecialchars(urldecode($parameterString)));
            print_r($response);
            print_r('</pre>');
            */
            
            return false;
        }
        curl_close($ch);
    }
    catch (Exception $e)
    {
        echo 'Caught exception: ',  $e->getMessage(), "\n";
        return false;
    }
}

/* Sends a SELECT query to the triple store 
 * and gets the result back.
 */
function getQueryResults($query)
{
    //return '****dddd***';
    
    //global $storeConfig, $log;
    try 
    {
        //$db = sparql_connect( "http://dbpedia.org/sparql");
        $db = sparql_connect( "http://hxl.humanitarianresponse.info/sparql" );
        
        if( !$db )
        {
            //$log->write($db->errno() . ": " . $db->error(). "\n");
            exit;
        }
        $result = $db->query($query);
        if( !$result )
        {
            //$log->write($db->errno() . ": " . $db->error(). "\n");
            exit;
        }
    }
    catch (Exception $e)
    {
        //$log->write('Caught exception: ',  $e->getMessage(), "\n");
    }
    return $result;
}

?>