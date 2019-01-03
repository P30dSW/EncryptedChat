$(document).ready(function () {
    
    //method when clicking a user card
    $(".users").click(function() {
        updateChatScreen(this);
     });
    //TODO: Method for pushing the send button
    //TODO: Method for deleting a message (Hint: id="deleteMessageBtn")
    //TODO: Method for editing a message (Hint: id="changeMessageBtn")
    //TODO: Keep message history current
});

//only for testing

/**
 * Updates the chat selection
 */
function updateChatScreen(obj) {
    //TODO: show the chat archive
    //Process:
    //1. Fetch all messages between the two users
    $.ajax({
        url: "http://localhost/EncryptedChat/Backend/chatApi.php",
        dataType: "json",
        headers: {
            'SESSION_ID':getCookie('PHPSESSID'),
            'FUNCTION': 'GET_MESSAGES',
            //enter target user ID
            'VAL01': obj.getAttribute("uid"),
        },
        error: function(error){ 
            console.log(error);
            return null;
        },
        success: function(json){
            console.log(json);
            //2. Remove all currently shown messages (Hint: class="simplebar-content")
            $(".msg_history").html("");
            scroll = "<div data-simplebar class='msg_scroll_content'>";
            $(".msg_history").append(scroll);

            //3. Insert all documented messages
            i = 1;

            while (typeof json[i] !== "undefined") {
                console.log(json[i]);
                element = json[i];
                i++;

                div = "<div class='received_msg'><p>mId: "+element.mId+" fromUser: "+element.fromUser+" toUser: "+element.toUser+"<br/>timeSend: "+element.timeSend+"<br/>message: "+element.message+"</p></div>";
                $(".msg_history").children().first().append(div);
            }
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