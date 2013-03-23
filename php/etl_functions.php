<?php

/*****************************
 * Puts the values into the ttl query
 *****************************/
function extractRowData($dbRow, $sourceTranslation, $currentEmergency)
{
    global $reporter, $reporterOrganisationAbbr, $ttlContainerHeader, $ttlContainerUri;
    global $log;

    $containerUriArray = array();
    $containerArray = array();
    
    $dateTime = new DateTime();
    $scriptDate = $dateTime->format('Y-m-d H:i:s');
    $timeStamp = microtime(true);

    $stringData = '';

    $tempContainerUri = str_replace("[%timeStamp%]", $timeStamp, $ttlContainerUri);
    array_push($containerUriArray, $tempContainerUri);
    
    $reportDate = $dbRow['ReportDate'];    
    
    $stringData .= makeContainerHeader($scriptDate, $tempContainerUri, $reporter, $reporterOrganisationAbbr, $ttlContainerHeader, $currentEmergency, $reportDate);
    $stringData .= makeTtlFromRow($dbRow, $sourceTranslation);
    
    array_push($containerArray, $stringData);	


    
    
    global $storeConfig, $curlDropOneContainer;
    
    $tempDrop = str_replace("[%graph%]", $tempContainerUri, $curlDropOneContainer);
    $tempDrop = str_replace("[%userPass%]", $storeConfig['store_username'] . ':' . $storeConfig['store_password'], $tempDrop);
    $tempDrop = str_replace("[%endPoint%]", $storeConfig['store_endpoint'], $tempDrop);
    
    return array ($containerUriArray, $containerArray, $tempDrop);
}


/*******************************
 *
 *****************************/
function makeContainerHeader($scriptDate, $containerUri,  $reporter, $reporterOrganisationAbbr, $ttlContainerHeader, $currentEmergency, $reportDate)
{
    $ttlContainerHeader = str_replace("[%containerUri%]", $containerUri, $ttlContainerHeader);
    if (!is_null($currentEmergency)) $ttlContainerHeader = str_replace("[%currentEmergency%]", $currentEmergency, $ttlContainerHeader);

    $ttlContainerHeader = str_replace("[%reportDate%]", $scriptDate, $ttlContainerHeader);
    if (!is_null($reporter)) $ttlContainerHeader = str_replace("[%reporter%]", $reporter, $ttlContainerHeader);
    if (!is_null($reporterOrganisationAbbr)) $ttlContainerHeader = str_replace("[%reporterOrg%]", $reporterOrganisationAbbr, $ttlContainerHeader);

    if (!is_null($reportDate)) $ttlContainerHeader = str_replace("[%validOn%]", $reportDate, $ttlContainerHeader);

    return $ttlContainerHeader;
}

/*******************************
 *
 *****************************/
function isRowOk($dbRow)
{
    global $log;
    
    $lookUpSuccessful = false;
    
    $settlementNamePcode = '';
    
    if (empty($dbRow['aplpcode'])) 
    {
        if (empty($dbRow['pplpcode'])) 
        {
            $settlementNamePcode = $dbRow['easyname'];
        }
        else
        {
            $settlementNamePcode = $dbRow['pplpcode'];
        }
    }
    else
    {
        $settlementNamePcode = $dbRow['aplpcode'];
    }
    
    $query= "PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#>
    SELECT * WHERE {
    ?location hxl:pcode \"" . $settlementNamePcode . "\" .
    ?location a ?type .
    }";

    $queryResult = getQueryResults($query);
    if ($queryResult->num_rows() == 0) 
    {
        //$log->write("Error: pcode of " . $dbRow['easyname'] . " not found.");
        //echo("Error: pcode of " . $dbRow['easyname'] . " not found.");
        /*
        echo '<br>-- look up failed: ';
        echo htmlspecialchars($query);
        echo '<br>';
         */
    }
    else 
    {
        $lookUpSuccessful = true;
    }
     
    if(countAvailable($dbRow, $dbRow['ReportDate']) &&
       $lookUpSuccessful)
    {
        return true;
    }
    else
    {
        return false;
    }
}


/*******************************
 *
 *****************************/
function makeTtlFromRow($dbRow, $sourceTranslation)
{
    global $log;

    $stringData = '';

    $rowSources = strtolower(str_replace(" ", "", $dbRow['source']));
    $currentSources = array();
    /*
        echo("<br>");
        echo("----");
        echo($dbRow['source']);
        echo("- - - ->");
        echo($rowSources);
        echo("<br>");
      */
    if (empty($rowSources) ||
        count($sourceTranslation[$rowSources]) == 0) {
        //echo("no source found, so default is used");
        $currentSources[$rowSources] = "UNHCR";
        //$log->write("Warning: No source found for the report of " . $dbRow['ReportDate']);
        //echo("Warning: No source found for the report of " . $dbRow['ReportDate']);
    }
    else
    {
        $currentSources = $sourceTranslation[$rowSources];
    }

    
    ////////////////////
    $age = "ages_0-4";
    //$dbRow['DEM_04_M']
    $sex = "male";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_04_M'], $currentSources);
    //$dbRow['DEM_04_F']
    $sex = "female";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_04_F'], $currentSources);

    ////////////////////
    $age = "ages_5-11";
    //$dbRow['DEM_511_M']
    $sex = "male";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_511_M'], $currentSources);
    //$dbRow['DEM_511_F']
    $sex = "female";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_511_F'], $currentSources);

    ////////////////////
    $age = "ages_12-17";
    //$dbRow['DEM_1217_M']
    $sex = "male";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_1217_M'], $currentSources);
    //$dbRow['DEM_1217_F']
    $sex = "female";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_1217_F'], $currentSources);

    ////////////////////
    $age = "ages_18-59";
    //$dbRow['DEM_1859_M']
    $sex = "male";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_1859_M'], $currentSources);
    //$dbRow['DEM_1859_F']
    $sex = "female";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_1859_F'], $currentSources);

    ////////////////////
    $age = "ages_60_and_over";
    //$dbRow['DEM_60_M']
    $sex = "male";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_60_M'], $currentSources);
    //$dbRow['DEM_60_F']
    $sex = "female";
    $stringData .= makeTtlPopDescription($dbRow, $sex, $age, $dbRow['DEM_60_F'], $currentSources);

    return $stringData;

}

/******************************
 *
 *****************************/
function makeTtlPopDescription($dbRow, $sex, $age, $popCount, $sourcesArray)
{
    if ($popCount == 0) 
    {
        return;
    }
    
    global $log, $ttlPersonCount, $ttlHouseholdCount, $ttlPopDescription, $ttlSubject, $ttlSex, $ttlAge, $ttlMethod, $ttlSource, $ttlPlaceOfOrigin;
    global $defaultPopulationType;

    $settlementNamePcode = '';
    
    
    /*
    echo '<pre>';
                print_r($dbRow);
                echo '</pre>';
                echo "<br />";
     * 
     */
                
    if (empty($dbRow['aplpcode'])) 
    {
        if (empty($dbRow['pplpcode'])) 
        {
            $settlementNamePcode = $dbRow['easyname'];
            $placeType = "apl";
        }
        else
        {
            if (strlen($dbRow['pplpcode']) <= 3)
            {
                $settlementNamePcode = $dbRow['pplpcode'];
                $placeType = "country";
            }
            else
            {
                $settlementNamePcode = $dbRow['pplpcode'];
                $placeType = "admin";
            }
        }
    }
    else
    {
        $settlementNamePcode = $dbRow['aplpcode'];
        $placeType = "apl";
    }
    
    // Quick fix about origin:
    $originCountryPcode = 'unknown';
    $originLocationPcode = 'UNKNOWN';
    switch ($dbRow['origin'])
    {
        case "Mali":
            $originCountryPcode = 'mli';
            $originLocationPcode = 'MLI';
            break;
        case "Burkina Faso":
            $originCountryPcode = 'bfa';
            $originLocationPcode = 'BFA';
            break;
        case "Niger":
            $originCountryPcode = 'ner';
            $originLocationPcode = 'NG';
            break;
        case "Mauritania":
            $originCountryPcode = 'mrt';
            $originLocationPcode = 'NG';
            break;
        case "Guinea":
            $originCountryPcode = 'gin';
            $originLocationPcode = 'GIN';
            break;
        case "Togo":
            $originCountryPcode = 'tgo';
            $originLocationPcode = 'TGO';
            break;
        default:
            $originCountryPcode = 'unknown';
            $originLocationPcode = 'UNKNOWN';
            break;
    }
        
    // Subject
    $ttlSubjectTemp = $ttlSubject;
    $ttlSubjectTemp = str_replace("[%populationType%]", $defaultPopulationType, $ttlSubjectTemp);
    $ttlSubjectTemp = str_replace("[%countryPCode%]", $dbRow['countrycode'], $ttlSubjectTemp);
    $ttlSubjectTemp = str_replace("[%campPCode%]", $settlementNamePcode, $ttlSubjectTemp);
    $ttlSubjectTemp = str_replace("[%originCountryPCode%]", $originCountryPcode, $ttlSubjectTemp);

    // Description
    $ttlSexTemp = $ttlSex;
    $ttlAgeTemp = $ttlAge;
    if (empty($sex) && empty($age))
    {
        $ttlSexTemp = "";
        $ttlAgeTemp = "";
    }
    else
    {
        $ttlSexTemp = str_replace("[%sex%]", $sex, $ttlSexTemp);
        $ttlAgeTemp = str_replace("[%age%]", $age, $ttlAgeTemp);		
    }

    $ttlPopDescriptionTemp = $ttlPopDescription;
    $ttlPopDescriptionTemp = str_replace("[%ttlSex%]", $ttlSexTemp, $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%ttlAge%]", $ttlAgeTemp, $ttlPopDescriptionTemp);

    // Country of origin
    $ttlPlaceOfOriginTemp = $ttlPlaceOfOrigin;
    $ttlPlaceOfOriginTemp = str_replace("[%originCountryPCode%]", $originCountryPcode, $ttlPlaceOfOriginTemp);
    $ttlPlaceOfOriginTemp = str_replace("[%originLocationPCode%]", $originLocationPcode, $ttlPlaceOfOriginTemp);
    
    $ttlPopDescriptionTemp = str_replace("[%ttlPlaceOfOrigin%]", $ttlPlaceOfOriginTemp, $ttlPopDescriptionTemp);
    
    
    if (empty($sex) && empty($age))
    {
        $ttlSubjectTemp = str_replace("[%sex%]/[%age%]", "household", $ttlSubjectTemp);
        $ttlPersonCountTemp = "";
        $ttlHouseholdCountTemp = $ttlHouseholdCount;
        $ttlHouseholdCountTemp = str_replace("[%householdCount%]", $popCount, $ttlHouseholdCountTemp);
        //$ttlPopDescriptionTemp = str_replace("[%ttlPopCount%]", $ttlPersonCountTemp, $ttlPopDescriptionTemp);
        //$ttlPopDescriptionTemp = str_replace("[%ttlHouseholdCount%]", $ttlHouseholdCountTemp, $ttlPopDescriptionTemp);
    }
    else
    {
        $ttlSubjectTemp = str_replace("[%sex%]", $sex, $ttlSubjectTemp);
        $ttlSubjectTemp = str_replace("[%age%]", $age, $ttlSubjectTemp);
        $ttlHouseholdCountTemp = "";
        $ttlPersonCountTemp = $ttlPersonCount;
        $ttlPersonCountTemp = str_replace("[%personCount%]", $popCount, $ttlPersonCountTemp);
    }
    $ttlPopDescriptionTemp = str_replace("[%ttlPopCount%]", $ttlPersonCountTemp, $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%ttlHouseholdCount%]", $ttlHouseholdCountTemp, $ttlPopDescriptionTemp);

    // atLocation
    $ttlPopDescriptionTemp = str_replace("[%placeType%]", $placeType, $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%countryPCode%]", $dbRow['countrycode'], $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%campPCode%]", $settlementNamePcode, $ttlPopDescriptionTemp);
    
    // sources
    $ttlSources = '';
    foreach ($sourcesArray as $source)
    {
        $ttlSources .= str_replace("[%source%]", strtolower($source), $ttlSource);
    }
    //echo htmlspecialchars($ttlSources);
            
    // Method is not mentioned in UNHCR database
    $ttlMethodTemp = str_replace("[%method%]", "", $ttlMethod);
    
    $ttlPopDescriptionTemp = str_replace("[%ttlSource%]", $ttlSources, $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%ttlMethod%]", $ttlMethodTemp, $ttlPopDescriptionTemp);
    $ttlPopDescriptionTemp = str_replace("[%subject%]", $ttlSubjectTemp, $ttlPopDescriptionTemp);

        
    return $ttlPopDescriptionTemp;
}

/*******************************
 * Check the existence of a pcode
 * returns true if the pcode correspond to an APL
 * returns false otherwise
 * logs an error message containing the type if it exists but is not an APL
 *****************************/
function pcodeLookup($dbRow)
{
    global $log;
    
    $lookUpSuccessful = false;
    
    $query= "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#>

    SELECT * WHERE {
    ?location hxl:pcode \"" . $dbRow['aplpcode'] . "\" .
    ?location a ?type .
    }";
 
/*
    echo '<br>';
    echo htmlspecialchars($query);
    echo '<br>';
 */
    
    $queryResult = getQueryResults($query);
    
    if ($queryResult->num_rows() == 0) 
    {
        $log->write("Look up failed. Description is about to be loaded for " . $dbRow['aplpcode']);
    }
    else 
    {
        while($row = $queryResult->fetch_array())
        {  
            if ($row["type"] == 'http://hxl.humanitarianresponse.info/ns/#APL')
            {
                $lookUpSuccessful = true;
            }
            else
            {
                $log->write($dbRow['aplpcode'] . " is of type: " . $row["type"] . ".");
            }
        } 
    }
     
    return $lookUpSuccessful;
}

/*******************************
 * Check the existence of a location name
 * returns true if the pcode correspond to an APL
 * returns false otherwise
 * logs an error message containing the type if it exists but is not an APL
 *****************************/
function nameLookup($dbRow)
{
    global $log;
    
    $lookUpSuccessful = false;
    
    $query = "PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#>

    SELECT * WHERE {
    ?location hxl:featurefName \"" . trim($dbRow['easyname']) . "\" . 
    ?location a ?type .
    }";

    
    $queryResult = getQueryResults($query);
    
    
    echo $queryResult->num_rows();
    echo '<br>';
    
    
    if ($queryResult->num_rows() == 0) 
    {
        $log->write("Error: name " . trim($dbRow['easyname']) . " not found.");//
    }
    else 
    {
        while($row = $queryResult->fetch_array())
        {  
            if ($row["type"] == 'http://hxl.humanitarianresponse.info/ns/#APL')
            {
                $lookUpSuccessful = true;
            }
            else
            {
                $log->write(trim($dbRow['easyname']) . " is of type: " . $row["type"] . ".");
            }
        } 
    }
    return $lookUpSuccessful;
}

/*******************************
 * 
 *****************************/
function locationLookup($easyName)
{
    global $log;
    
    $lookUpSuccessful = false;
    
    $query= "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
    PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#>

    SELECT * WHERE { GRAPH ?graph {
    ?location ?typeOfThePlace ?easyname .
    FILTER regex(?easyname, \"" . $easyName . "\", \"i\" )
    ?location ?predicate ?object .
    } }";
 
/*
    echo '<br>';
    echo htmlspecialchars($query);
    echo '<br>';
 */
    
    $queryResult = getQueryResults($query);
    
    if ($queryResult->num_rows() == 0) 
    {
        $log->write("<br><br>" . "Look up failed. Description is about to be loaded for " . $easyName . "<br><br>");
    }
    else 
    {
        $lookUpSuccessful = true;
        /*print_r("<pre>");
        print_r($queryResult);
        print_r("</pre>");*/
        
        
                print_r("<br>--------------------------------<br>");
                print_r("<b>" . $easyName . ":</b><br>");
        while($row = $queryResult->fetch_array())
        {  
            if ($row["graph"] != 'http://hxl.humanitarianresponse.info/data/datacontainers/1234567890.111111')
            {
                print_r("graph: " . $row["graph"] . "<br>");
                print_r($row["location"] . " - ");
                print_r($row["predicate"] . " - ");
                print_r($row["object"] . " . <br>");
                print_r("<br>");
            }
            else
            {
                continue;
            }
        } 
    }
     
    return $lookUpSuccessful;
}

/*******************************
 * Returns the source translation table
 *****************************/
function translateSources()
{
    global $mysqlQuerySources, $sourceConfig, $log;

    // Query
    $mysqli = new mysqli($sourceConfig['db_host'], $sourceConfig['db_user_name'], $sourceConfig['db_password'], $sourceConfig['db_name']);
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }

    $array = array();
    
    // Checking the content
    if ($dbContent = $mysqli->query($mysqlQuerySources))
    {
        while($dbRow = mysqli_fetch_array($dbContent))
        {
            $sources = explode(",", $dbRow['output']);
            $tmp = strtolower(str_replace(" ", "", $dbRow['input']));
            $array[$tmp] = $sources;
        }
    }
    
    return $array;
}


/* 
 * 
 */
function countAvailable($row, $reportDate)
{
    global $log;

    if (empty($row['DEM_04_M']) &
        empty($row['DEM_04_F']) &
        empty($row['DEM_511_M']) &
        empty($row['DEM_511_F']) &
        empty($row['DEM_1217_M']) &
        empty($row['DEM_1217_F']) &
        empty($row['DEM_1859_M']) &
        empty($row['DEM_1859_F']) &
        empty($row['DEM_60_M']) &
        empty($row['DEM_60_F']) &
        empty($row['TotalRefPop_HH']) &
        empty($row['TotalRefPop_I']))
    {
        //$log->write("Warning: No detail of population count found at " . $row['aplpcode'] . " on " . $reportDate);
        //echo("Warning: No detail of population count found at " . $row['aplpcode'] . " on " . $reportDate);
        
        return false;
    }
    else
    {
        return true;
    }
}


/*******************************
 *
 *****************************/
function printResultArray($dbContent)
{

    $i = 0;
    printf("Select returned %d rows.<br /><br />\n", $dbContent->num_rows);
    printf("We retain 11 columns of distinct age/sex type. It makes a total of 11 columns * %d rows or containers = %d population counts and household counts all together.<br /><br />\n", $dbContent->num_rows, $dbContent->num_rows * 11);

    // The Updated date doesn't correspond at all and can differ significantly from the date it is supposed to be valid on.
    // The report date is used because it is the closest from the reality.
    $reportDate = $row['ReportDate'];
    
    echo "<table><tr>";
    echo "<td>#</td>";
    echo "<td>ReportDate</td>";
    echo "<td>Set. pcode</td>";

    echo "<td>country. pcode</td>";
    echo "<td>origin</td>";
    echo "<td>Total HH</td>";
    echo "<td>Total I</td>";
    echo "<td>0-4 M</td>";
    echo "<td>0-4 F</td>";
    echo "<td>5-11 M</td>";
    echo "<td>5-11 F</td>";
    echo "<td>12-17 M</td>";
    echo "<td>12-17 F</td>";
    echo "<td>18-59 M</td>";
    echo "<td>18-59 F</td>";
    echo "<td>60 M</td>";
    echo "<td>60 F</td>";
    echo "<td>Source</td>";
    echo "</tr>";
    while($row = mysqli_fetch_array($dbContent)) {
        $i++;
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>{$reportDate}</td>";
        echo "<td>{$row['aplpcode']}</td>";
        echo "<td>{$row['countrycode']}</td>";
        echo "<td>{$row['origin']}</td>";
        echo "<td>{$row['TotalRefPop_HH']}</td>";
        echo "<td>{$row['TotalRefPop_I']}</td>";
        echo "<td>{$row['DEM_04_M']}</td>";
        echo "<td>{$row['DEM_04_F']}</td>";
        echo "<td>{$row['DEM_511_M']}</td>";
        echo "<td>{$row['DEM_511_F']}</td>";
        echo "<td>{$row['DEM_1217_M']}</td>";
        echo "<td>{$row['DEM_1217_F']}</td>";
        echo "<td>{$row['DEM_1859_M']}</td>";
        echo "<td>{$row['DEM_1859_F']}</td>";
        echo "<td>{$row['DEM_60_M']}</td>";
        echo "<td>{$row['DEM_60_F']}</td>";
        echo "<td>{$row['source']}</td>";
        echo "</tr>";
    }
    echo "</table>";
     
    $dbContent->close();
}

/*******************************
 *
 *****************************/
function displayDropCurlCommand($graph)
{
    global $storeConfig, $curlDropOneContainer, $curlDropFile, $log;
    
    $stringData = str_replace("[%graph%]", $graph, $curlDropOneContainer);
    $stringData = str_replace("[%userPass%]", $storeConfig['store_username'] . ':' . $storeConfig['store_password'], $stringData);
    $stringData = str_replace("[%endPoint%]", $storeConfig['store_endpoint'], $stringData);
    
    
    print_r('<pre>');
    print_r($stringData);
    print_r('</pre>');
   
    $fileHandle = fopen($curlDropFile, 'w') or die("can't open file");
    fwrite($fileHandle, $stringData);
    fclose($fileHandle);

}

/*******************************
 *
 *****************************/
function displayDropEmergencyContainers($dbContent)
{
    global $storeConfig, $curlDropOneEmergency, $curlDropFile, $log;
    
    $stringData = '';
    
    while($row = mysqli_fetch_array($dbContent))
    {
        $tempDataData = str_replace("[%endPoint%]", $storeConfig['store_endpoint'], $curlDropOneContainer);
        $tempDataData = str_replace("[%userPass%]", $storeConfig['store_username'] . ':' . $storeConfig['store_password'], $tempDataData);
        $stringData .= $tempData;
    }
    
    print_r('<pre>');
    print_r($stringData);
    print_r('</pre>');
   
    $fileHandle = fopen($curlDropFile, 'w') or die("can't open file");
    fwrite($fileHandle, $stringData);
    fclose($fileHandle);
}

/*****************************
 * 
 *****************************/
function printContainers($dbContent)
{
    global $reporter, $reporterOrganisationAbbr, $ttlContainerHeader, $ttlContainerUri, $ttlPrefixes, $currentEmergency;
    global $timeStamp, $scriptDate;

    global $log;

    $log->write("----------------------------------------------------------------");
    $log->write("Number of rows: " . $dbContent->num_rows);
    $log->write("Number of count columns: 11");
    $log->write("General note: The default population type is hxl:RefugeesAsylumSeekers");
    $log->write("General warning: Unknow reporter IDs and absent or multiple sources in table datarefpop. The hxl:reportedBy is set to $reporter.");
    $log->write("General warning: No country pcode. Using temporary pcodes from the conversion table.");
    $log->write("General warning: No APL pcode. Using temporary pcodes from the conversion table.");
    $log->write("General warning: No origin pcode. Using temporary pcodes from the conversion table.");
    $log->write("General warning: No method reported.");

    $i = 0;
    $containerUriArray = array();
    $containerArray = array();
    while($dbRow = mysqli_fetch_array($dbContent))
    {
        $stringData = '';
        $i++;

        $ttlContainerUri = str_replace("[%timeStamp%]", $timeStamp, $ttlContainerUri);
        array_push($containerUriArray, $ttlContainerUri);

        $stringData .= $ttlPrefixes;
        
        $reportDate = $dbRow['ReportDate'];
        if ($dbRow['ReportDate'] != $dbRow['UpdatedDate'])
        {
            $reportDate = $dbRow['UpdatedDate'];
        }
        $stringData .= makeContainerHeader($scriptDate, $ttlContainerUri, $reporter, $reporterOrganisationAbbr, $ttlContainerHeader, $currentEmergency, $reportDate);
        
        $ttfRow = makeTtlFromRow($dbRow);
        if ($ttfRow != false)
        {
            $stringData .= $ttfRow;
        }
        
        array_push($containerArray, $stringData);


        //if($i == 2) break;
        
			
     }	
     /* to print the list of container URIs and containers */
    print_r("<pre>");
    print_r($containerUriArray);
    print_r("</pre>");
    print_r("<br />");
    print_r("<pre>");
    print_r($containerArray);
    print_r("</pre>");
     
}

?>