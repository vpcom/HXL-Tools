
<?php
//global $ttlPrefixes;

ini_set('max_execution_time', 600); 
/*
include_once('sparqllib.php');
include_once('sparqlFunctions.php');
*/
require_once('../php/etl_functions.php');
require_once('../php/init_AJAX.php');

$action = $_POST['action'];
$path = $_POST['path'];
//echo $path;
//echo $action;


switch ($action) {
    case 'load':
        

        $directory  = DIR_DOCS . $path . '/';//'ttl_refugees_unhcr/'; 
        $files = scandir($directory);
        $ignore = Array(".", "..");
        $count=1;
        $errorCount = 0;
        $successCount = 0;
        //echo '<table class="table">';
        foreach($files as $file)
        {

        //if ($count == 2) break;

            if(!in_array($file, $ignore))
            {
                $section = file_get_contents($directory . $file);

                $query = $ttlPrefixes . ' INSERT DATA { GRAPH <http://hxl.humanitarianresponse.info/data/datacontainers/' . substr($file, 0, -4) . '> { ' . $section . '}}';
                if (!sparqlUpdate($query))
                {
                    $errorCount++;
                }
                else
                {
                    $successCount++;
                }

                     //echo $section;   
                //echo $query;//htmlspecialchars($query);
                //echo '<br>';
                $count++;
            }
        }
        
        echo $successCount;
        /*echo '<br>--';
        echo $count;
        echo '<br>--';
        echo '<br>';
        echo $errorCount;
        echo '<br>--';
        echo '<br>';*/

    
        break;  
}

            /* Full working example
             * 
             * prefix hxl: <http://hxl.humanitarianresponse.info/ns/#> 
        prefix geo: <http://www.opengis.net/ont/geosparql#> 
        prefix dc: <http://www.w3.org/2001/XMLSchema#> 
        prefix xsd: <http://www.w3.org/2001/XMLSchema#> 
        prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
        ' . substr($file, 0, -4) . '
        */
              /*$query = 'prefix hxl: <http://hxl.humanitarianresponse.info/ns/#> 
        prefix geo: <http://www.opengis.net/ont/geosparql#> 
        prefix dc: <http://www.w3.org/2001/XMLSchema#> 
        prefix xsd: <http://www.w3.org/2001/XMLSchema#> 
        prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
        INSERT DATA { GRAPH <http://hxl.humanitarianresponse.info/data/datacontainers/12345678999.222001> { ' .
                      '<http://hxl.humanitarianresponse.info/data/datacontainers/12345678999.222001> a hxl:DataContainer .
        <http://hxl.humanitarianresponse.info/data/datacontainers/12345678999.222001> hxl:aboutEmergency <http://hxl.humanitarianresponse.info/data/emergencies/mali2012test> .
        <http://hxl.humanitarianresponse.info/data/datacontainers/12345678999.222001> dc:date "2012-12-06"^^xsd:date .
        <http://hxl.humanitarianresponse.info/data/datacontainers/12345678999.222001> hxl:validOn "2012-10-28" .
        <http://hxl.humanitarianresponse.info/data/datacontainers/12345678999.222001> hxl:reportCateogry <http://hxl.humanitarianresponse.info/data/reportcategories/humanitarian_profile> .
        <http://hxl.humanitarianresponse.info/data/datacontainers/12345678999.222001> hxl:reportedBy <http://hxl.humanitarianresponse.info/data/persons/unocha/vincent_perrin> .

        <http://hxl.humanitarianresponse.info/data/idp/mli/MLI001/mli/mli> hxl:atLocation <http://hxl.humanitarianresponse.info/data/locations/admin/mli/MLI001> .
        <http://hxl.humanitarianresponse.info/data/idp/mli/MLI001/mli/mli> rdf:type hxl:IDP .
        <http://hxl.humanitarianresponse.info/data/idp/mli/MLI001/mli/mli> hxl:nationality <http://hxl.humanitarianresponse.info/data/locations/admin/mli/MLI> .
        <http://hxl.humanitarianresponse.info/data/idp/mli/MLI001/mli/mli> hxl:placeOfOrigin <http://hxl.humanitarianresponse.info/data/locations/admin/mli/MLI> .
        <http://hxl.humanitarianresponse.info/data/idp/mli/MLI001/mli/mli> hxl:personCount "46448"^^xsd:integer .
        <http://hxl.humanitarianresponse.info/data/idp/mli/MLI001/mli/mli> hxl:source <http://hxl.humanitarianresponse.info/data/organisations/unocha> .
        <http://hxl.humanitarianresponse.info/data/idp/mli/MLI001/mli/mli> hxl:method "Household reg." .

        }}';      

            
             */
?>