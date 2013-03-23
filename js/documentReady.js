/* 
 * 
 */
// Prefixes for all queries
var queryPrefix = "PREFIX hxl: <http://hxl.humanitarianresponse.info/ns/#> \n";
queryPrefix += "PREFIX geo: <http://www.opengis.net/ont/geosparql#> \n";
queryPrefix += "PREFIX dc: <http://purl.org/dc/terms/> \n";
queryPrefix += "PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> \n";
queryPrefix += "PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> \n";
queryPrefix += "PREFIX foaf: <http://xmlns.com/foaf/0.1/> \n";
queryPrefix += "PREFIX xsd: <http://www.w3.org/2001/XMLSchema#> \n";
queryPrefix += "PREFIX skos: <http://www.w3.org/2004/02/skos/core#> \n \n";


/* 
 * Get the emergency list.
 */
function getEmergenciesInfo () 
{
    jQuery.support.cors = true; // for IE8+

    var jsonObject = new Array();
    
    $query = queryPrefix;
    $query += 'SELECT DISTINCT ?emergencyDisplay ?emergencyUri WHERE { \n';//?emergencyUri 
    $query += 'GRAPH ?graph { \n';
    $query += '?emergencyUri rdf:type hxl:Emergency . \n';
    $query += '?emergencyUri hxl:commonTitle ?emergencyDisplay . \n';
    $query += '} \n';
    $query += '} \n';
    $query += 'ORDER BY ?emergencyUri \n';
    
    //console.log($query);

    $.ajax
    ({
        url: 'http://hxl.humanitarianresponse.info/sparql',
        headers: 
        {
            Accept: 'application/sparql-results+json'
        },
        data: 
        { 
            query: $query 
        },
        datatype: "json",
        success: displayData, 
        error: displayError,
        async: false
    });

    function displayError(xhr, textStatus, errorThrown) 
    {
        jsonObject = false;
        alert(textStatus + ': ' + errorThrown);
    }

    function displayData(data) 
    {
        if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent))
        {
            jsonObject = jQuery.parseJSON(data);
            if (jsonObject == null) // Necessary for FF on blackmesh
            {
                jsonObject = data.results.bindings;
            }
        } 
        else 
        {
            jsonObject = data.results.bindings;
        }
    }
    return jsonObject;
}
  
/* 
 * Get the population types.
 */
function getPopTypes () 
{
    jQuery.support.cors = true; // for IE8+

    var jsonObject = new Array();
    
    $query = queryPrefix;
    $query += 'SELECT DISTINCT ?popType WHERE { \n';
    $query += '?popType rdfs:subClassOf hxl:Displaced . \n';
    $query += '} \n';
    //console.log($query);

    $.ajax
    ({
        url: 'http://hxl.humanitarianresponse.info/sparql',
        headers: 
        {
            Accept: 'application/sparql-results+json'
        },
        data: 
        { 
            query: $query 
        },
        datatype: "json",
        success: displayData, 
        error: displayError,
        async: false
    });

    function displayError(xhr, textStatus, errorThrown) 
    {
        jsonObject = false;
        alert(textStatus + ': ' + errorThrown);
    }

    function displayData(data) 
    {
        if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent))
        {
            jsonObject = jQuery.parseJSON(data);
            if (jsonObject == null) // Necessary for FF on blackmesh
            {
                jsonObject = data.results.bindings;
            }
        } 
        else 
        {
            jsonObject = data.results.bindings;
        }
    }
    return jsonObject;
}
  
  
$(document).ready(function()
{
    //console.log("*****");
    // When clicking on the button close or the mask layer the popup closed
    
    // Logout
    $('a#logout').bind('click', function() { 
        setCookie("username", '', null); // logged in for a day
        return false;
    });


    // enables bootstrap tooltips
    $('#tooltip').tooltip();
    
    // selects the content of an input box on click
    $("input[type=text]").click(function() {
        $(this).select();
    });

    var currentNickName = getCookie("username");
    //console.log('username' + username);
    if (typeof currentNickName == 'undefined' ||
        currentNickName == '')
    {
        $('div#theContent').hide();
        loginPopup();

        // press enter for validation of login
        $("#password").keyup(function(event){
            if(event.keyCode == 13){
                $("#login").click();
            }
        });

        /*
        * Login request
        */
        $('button#login').click(function()
        {
            //alert($('#usernameXml').html());
            
            //console.log($('#nicknameXml').html()); 
            array_userName = $('#usernameXml').html().split(",");
            array_password = $('#passwordXml').html().split(",");
            array_nickName = $('#nicknameXml').html().split(",");
            
            array_userName.pop();
            array_password.pop();
            array_nickName.pop();
         

            if ($.inArray(document.getElementById('username').value, array_userName) != -1 &&
                $.inArray(document.getElementById('password').value, array_password) != -1)
            {
                //console.log('ok'); 
                currentNickName = array_nickName[$.inArray(document.getElementById('username').value, array_userName)];
                
                setCookie("username", currentNickName, 1);// logged in for a day

                // display 
                $('div#theContent').show();
                $('#mask , .login-popup').fadeOut(300 , function() {
                    $('#mask').hide();  
                }); 
                $('a#login-link').hide();
                $('a#logout').show();
                $('span#welcome_phrase').html('Hi ' + currentNickName + '!'); 
                $('span#welcome_phrase').show();
            }
            else
            {
                $('span#login_message').show();
            }

            return false;
        });

        /*
        * Click on dark background to close popup
        *
        $('div#mask').click(function()
        {
            $('#mask , .login-popup').fadeOut(300 , function() {
                $('#mask').hide();  
            }); 
            $('a#logout').hide();
            $('a#login-link').show();
            return false;
        });
        
        /*
        * Click on the close button to close popup
        $('a.close, #mask').bind('click', function() { 
            $('#mask , .login-popup').fadeOut(300 , function() {
                $('#mask').hide();  
            }); 
            return false;
        });
        
        // click on 'Login' to see the login popup
        $('a.login-window').click(loginPopup);

        */
        
        
    
        
    }
    else
    {
        $('div#theContent').show();
        $('a#login-link').hide();
        $('a#logout').show();
        $('span#welcome_phrase').html('Hi ' + currentNickName + '!');
        $('span#welcome_phrase').show();
        
        // Making the list of emergency names
        var emergenciesList = getEmergenciesInfo();
        var emeFound = false;
        var eme_init = "http://hxl.humanitarianresponse.info/data/emergencies/mali2012test";
    //console.log(emergenciesList.length);
        if (typeof emergenciesList != 'undefined')
        {    
            for (var i = 0 ; i < emergenciesList.length; i++) 
            {
                if (!emeFound &&
                    emergenciesList[i]['emergencyUri'].value == eme_init)
                {
                    emeFound = true;
                }
                
                /* simple emergency list for deleting emergency
                $('#emeChoiceList ul').append($('<li>', {
                    text: emergenciesList[i]['emergencyDisplay'].value
                }));*/

                // dropdown list for querying an emergency 
                $('#eme_uri_list').append('<li><a href="" id="' + emergenciesList[i]['emergencyUri'].value + '" >' + emergenciesList[i]['emergencyUri'].value + '</a></li>');
                
                // dropdown list for querying an emergency for population types
                $('#eme_pop_list').append('<li><a href="" id="' + emergenciesList[i]['emergencyUri'].value + '" >' + emergenciesList[i]['emergencyUri'].value + '</a></li>');
                
                // dropdown list for deleting an emergency for population types
                $('#del_popType_eme_uri_list').append('<li><a href="" id="' + emergenciesList[i]['emergencyUri'].value + '" >' + emergenciesList[i]['emergencyUri'].value + '</a></li>');
            }
            
            // init
            if (emeFound)
            {
                $('#eme_uri_list_but').html(eme_init + ' <span class="caret"></span>');
                $('#eme_uri_list_but_pop').html(eme_init + ' <span class="caret"></span>');
                $('#del_popType_eme_uri_list_but').html(eme_init + ' <span class="caret"></span>'); 
                $('#mem_eme').html(eme_init);
                $('#see_eme_btn').attr('href', eme_init);
                $('#see_eme_pop_btn').attr('href', eme_init);
            }
        }
        
                
        // Making the list of population types
        var popTypes = getPopTypes();
        //console.log(emergenciesList.length);
        var popTypeFound = false;
        var popType_init = "http://hxl.humanitarianresponse.info/ns/#RefugeesAsylumSeekers";
        if (typeof popTypes != 'undefined')
        {    
            for (var i = 0 ; i < popTypes.length; i++) 
            {
                if (!popTypeFound &&
                    popTypes[i]['popType'].value == popType_init)
                {
                    popTypeFound = true;
                }
                
                // dropdown list for querying an emergency 
                $('#pop_list').append('<li><a href="" id="' + popTypes[i]['popType'].value + '" >' + popTypes[i]['popType'].value + '</a></li>');
                // dropdown list for querying an emergency for deeleting populations
                $('#del_eme_pop_list').append('<li><a href="" id="' + popTypes[i]['popType'].value + '" >' + popTypes[i]['popType'].value + '</a></li>');
                
            }  
            // init
            if (popTypeFound)
            {
                $('#pop_list_but').html(popType_init + ' <span class="caret"></span>');
                $('#del_eme_pop_list_but').html(popType_init + ' <span class="caret"></span>');
                $('#mem_popTypes').html(popType_init);
                $('#see_pop_btn').attr('href', popType_init);
            }
        }
    }
    
});
