$(document).ready(function () {
    
    //method when clicking a user card
    $(".users").click(function() {
        updateChatScreen(this);
     });
    //TODO: Method for pushing the send button
    //TODO: Method for deleting a message
    //TODO: Method for editing a message
});

//only for testing

/**
 * Updates the chat selection
 */
function updateChatScreen(obj) {
    //TODO: show the chat archive
    //example of a ajax request to the REST api
    console.log($(obj).attr("uId"));
    $.ajax({
        url: "http://localhost/EncryptedChat/Backend/chatApi.php",
        dataType: "json",
        headers: {
            'SESSION_ID':getCookie('PHPSESSID'),
            'FUNCTION': 'SEND_MESSAGE',
            'VAL01': $(obj).attr("uId"),
            'VAL02':"Hello World"

        },
        error: function(erorr){ 
            console.log(erorr);
      },
      success: function(json){
        console.log(json);
      }
          });

}


//function to get Cookie
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }