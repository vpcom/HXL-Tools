/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


            
function loginPopup()
{	
    //Fade in the Popup
    $('#login-box').fadeIn(300);

    //Set the center alignment padding + border see css style
    var popMargTop = ($('#login-box').height() + 24) / 2; 
    var popMargLeft = ($('#login-box').width() + 24) / 2; 

    $('#login-box').css({ 
        'margin-top' : -popMargTop,
        'margin-left' : -popMargLeft
    });

    // Add the mask to body
    $('#mask').fadeIn(300);

    document.getElementById('username').focus();
	
    if ($('#usernameXml').html() == "") alert("Error: no login information found");

    return false;
}
