$(document).ready(function () {
    
    //method when clicking a user card
    $(".users").click(function() {
        updateChatScreen(this);
     });
    //Method for pushing the send button
    $("#sendMsg").click(function() {
        message = $("#toSendMsg").val();
        //console.log(message);
        userId = $("#sendMsg").attr("uId");
        if (userId == 0) {
            alert("Select a user first");
            return null;
        }
        sendMessageFromInput(userId, message);
        //remove sent message from input box
        $("#toSendMsg").val("");
    })
    //Keep message history current every five seconds
    setInterval(refreshMessages, 5000)
    //refresh when done
    refreshMessages();
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
            i = 10;

            while (i > 0) {
                if (typeof json[i] == "undefined") {
                    continue;
                }
                element = json[i];
                i--;

                div = "<div class='received_msg'><p>mId: "+element.mId+" fromUser: "+element.fromUser+" toUser: "+element.toUser+"<br/>timeSend: "+element.timeSend+"<br/>message: "+element.message+"</p></div>";
                $(".msg_history").children().first().append(div);
            }

            //4. tell send button which user is currently selected
            $("#sendMsg").attr("uId", obj.getAttribute("uid"));
        }
    });
}

//send message in the message input
function sendMessageFromInput(toUser, input) {
    $.ajax({
        url: "http://localhost/EncryptedChat/Backend/chatApi.php",
        headers: {
            'SESSION_ID':getCookie('PHPSESSID'),
            'FUNCTION': 'SEND_MESSAGE',
            //enter target user ID
            'VAL01': toUser,
            'VAL02': input,
        },
        error: function(error){ 
            console.log(error);
            return null;
        },
        success: function(){
            console.log(toUser+": "+input);
            refreshMessages();
        }
    });
}

//refresh message history
function refreshMessages() {
    //fetch partner ID
    partnerId = $("#sendMsg").attr("uId");
    //clear message board
    $(".msg_history").html("");
    scroll = "<div data-simplebar class='msg_scroll_content'>";
    $(".msg_history").append(scroll);
    //handle 0
    if (partnerId == 0) {
        console.log("no partner selected");
        return null;
    }
    //fill message board
    $.ajax({
        url: "http://localhost/EncryptedChat/Backend/chatApi.php",
        dataType: "json",
        headers: {
            'SESSION_ID':getCookie('PHPSESSID'),
            'FUNCTION': 'GET_MESSAGES',
            //enter target user ID
            'VAL01': partnerId,
        },
        error: function(error){ 
            console.log(error);
            return null;
        },
        success: function(json){
            //clear message board (again
            $(".msg_history").html("");
            scroll = "<div data-simplebar class='msg_scroll_content'>";
            $(".msg_history").append(scroll);

            //set all returned messages
            i = 10;
            while (i > 0) {
                if (typeof json[i] == "undefined") {
                    continue;
                }
                element = json[i];
                i--;

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