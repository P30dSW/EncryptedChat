var currentChatJSON = [];
var canUpdate = true;
$(document).ready(function () {
    
    //method when clicking a user card
    $(".users").click(function() {
        currentChatJSON = [];
        $("#toSendMsg").removeAttr("disabled");
        $("#sendMsg").removeAttr("disabled");
        updateChatScreen(this);
     });
    //Method for pushing the send button
    $("#sendMsg").click(function() {
        message = $("#toSendMsg").val();
        //console.log(message);
        userId = $("#sendMsg").attr("uId");
        if (userId == 0) {
            //TODO:add bootstrap alert
            alert("Select a user first");
            return null;
        }
        sendMessageFromInput(userId, message);
        //remove sent message from input box
        $("#toSendMsg").val("");
    })
    //Keep message history current every five seconds
    setInterval(refreshMessages, 5000);
    $(document).on("click","#deleteMessageBtn",deleteMessage);
    $(document).on("click","#changeMessageBtn",showEditModal);
    $("#editMessageSendBtn").click(editMessage);
    
});

//only for testing

/**
 * Updates the chat selection
 */
function updateChatScreen(obj) {
    //TODO: show the chat archive
    //Process:
    //1. Fetch all messages between the two users
    canUpdate = false;
    toUserId = obj.getAttribute("uid");
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
            $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error:"+ error +" <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
            return null;
        },
        success: function(json){
            
            if(json === false){
                $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error: Something went wrong with the Messagingsystem." + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
                
                return;
            }
            //2. Remove all currently shown messages (Hint: class="simplebar-content")
            currentChatJSON = json;
            $(".msg_history").fadeOut(400,function(){

            
            $(".msg_history").html("");
            scroll = "<div data-simplebar class='msg_scroll_content'>";
            $(".msg_history").append(scroll);
            
            if(json.length != 0){
                $.each(json, function(i){ 
                    
                    if (typeof json[i] != "undefined") {
                        element = json[i];
                        //checks if the message is from or to
                        
                        if(json[i].toUserId != toUserId){
                            if(element.isEdited){
                                div = "<div class='received_msg'><p mId=" +element.mId+" fromUserId=" +element.fromUserId +" toUserId=" + element.toUserId + ">"+element.message+"</br><small><i>EDITED | "+ element.timeSend+"</i></small> </p></div>";

                            }else{
                                div = "<div class='received_msg'><p mId=" +element.mId+" fromUserId=" +element.fromUserId +" toUserId=" + element.toUserId + ">"+element.message+"</br><small><i>"+ element.timeSend+"</i></small> </p></div>";

                            }
                            $(".msg_history").children().first().append(div);
                        }else{
                            if(element.isEdited){
                                div = "<div class='sent_msg'><p mId=" +element.mId+" fromUserId=" +element.fromUserId +" toUser=" + element.toUserId + ">"+ element.message+"</br><small><i>EDITED | "+ element.timeSend+"</i></small><br><button id='changeMessageBtn' type='button' class='changeMessageBtn btn btn-secondary btn-sm rounded-circle' href='#' data-target='#editMessageMdl' data-toggle='modal' data-backdrop='static' data-keyboard='false'>✏</button><button id='deleteMessageBtn' type='button' class=' btn btn-secondary btn-sm rounded-circle'>🗑</button></p></div>";
                            }else{
                                div = "<div class='sent_msg'><p mId=" +element.mId+" fromUserId=" +element.fromUserId +" toUser=" + element.toUserId + ">"+ element.message+"</br><small><i>"+ element.timeSend+"</i></small><br><button id='changeMessageBtn' type='button' class='changeMessageBtn btn btn-secondary btn-sm rounded-circle' href='#' data-target='#editMessageMdl' data-toggle='modal' data-backdrop='static' data-keyboard='false'>✏</button><button id='deleteMessageBtn' type='button' class=' btn btn-secondary btn-sm rounded-circle'>🗑</button></p></div>";

                            }
                            $(".msg_history").children().first().append(div);
                        }
                    }
                });
           
            //3. Insert all documented messages
            //4. tell send button which user is currently selected
            $("#sendMsg").attr("uId", obj.getAttribute("uid"));
            
            
        }else{
            $(".msg_history").children().first().append("<p>no Messages</p>");
            $("#sendMsg").attr("uId", obj.getAttribute("uid"));
        }
    });
    $(".msg_history").fadeIn();
        }
    });
    canUpdate=true;
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
            $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error:"+ error +" <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
            return null;
        },
        success: function(state){
            if(state == false){
                $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Something went wrong with the messaging system." +" <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
                return;
            }
            
            refreshMessages();
        }
    });
}

//refresh message history
function refreshMessages() {
    //fetch partner ID
    if(canUpdate == false){
        return;
    }
    partnerId = $("#sendMsg").attr("uId");
    //clear message board
   
    //handle 0
    if (partnerId == 0) {
        return ;
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
            $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error:"+ error +" <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
            return null;
        },
        success: function(json){
            //clear message board (again)
            //if the json is equal as the chat json, then there is no need to update
            if(json === false){
                $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error: Something went wrong with the Messagingsystem." + "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
                return;
            }
            if(_.isEqual(currentChatJSON, json)){
                
            }else{
                currentChatJSON = json;
                $(".msg_history").fadeOut(400,function(){

            
                    $(".msg_history").html("");
                    scroll = "<div data-simplebar class='msg_scroll_content'>";
                    $(".msg_history").append(scroll);
                    if(json.length != 0){
                        $.each(json, function(i){ 
                            
                            if (typeof json[i] != "undefined") {
                                element = json[i];
                                //checks if the message is from or to
                                
                                if(json[i].toUserId != toUserId){
                                    if(element.isEdited){
                                        div = "<div class='received_msg'><p mId=" +element.mId+" fromUserId=" +element.fromUserId +" toUserId=" + element.toUserId + ">"+element.message+"</br><small><i>EDITED | "+ element.timeSend+"</i></small> </p></div>";

                                    }else{
                                        div = "<div class='received_msg'><p mId=" +element.mId+" fromUserId=" +element.fromUserId +" toUserId=" + element.toUserId + ">"+element.message+"</br><small><i>"+ element.timeSend+"</i></small> </p></div>";

                                    }
                                    $(".msg_history").children().first().append(div);
                                }else{
                                    if(element.isEdited){
                                        div = "<div class='sent_msg'><p mId=" +element.mId+" fromUserId=" +element.fromUserId +" toUser=" + element.toUserId + ">"+ element.message+"</br><small><i>EDITED | "+ element.timeSend+"</i></small><br><button id='changeMessageBtn' type='button' class='changeMessageBtn btn btn-secondary btn-sm rounded-circle' href='#' data-target='#editMessageMdl' data-toggle='modal' data-backdrop='static' data-keyboard='false'>✏</button><button id='deleteMessageBtn' type='button' class=' btn btn-secondary btn-sm rounded-circle'>🗑</button></p></div>";
                                    }else{
                                        div = "<div class='sent_msg'><p mId=" +element.mId+" fromUserId=" +element.fromUserId +" toUser=" + element.toUserId + ">"+ element.message+"</br><small><i>"+ element.timeSend+"</i></small><br><button id='changeMessageBtn' type='button' class='changeMessageBtn btn btn-secondary btn-sm rounded-circle' href='#' data-target='#editMessageMdl' data-toggle='modal' data-backdrop='static' data-keyboard='false'>✏</button><button id='deleteMessageBtn' type='button' class=' btn btn-secondary btn-sm rounded-circle'>🗑</button></p></div>";
  
                                    }
                                    $(".msg_history").children().first().append(div);
                                }
                            }
                        });
                   
                    //3. Insert all documented messages
                    //4. tell send button which user is currently selected
                    $("#sendMsg").attr("uId", partnerId);
                    
                    
                }else{
                    $(".msg_history").children().first().append("<p>no Messages</p>");
                    $("#sendMsg").attr("uId", partnerId);
                }
            });
            $(".msg_history").fadeIn();
            }
           
        }
    });
}

function deleteMessage(){
var mId = $(this).parent().attr("mId");
 $.ajax({
     url: "http://localhost/EncryptedChat/Backend/chatApi.php",
     dataType: "json",
     headers: {
         'SESSION_ID':getCookie('PHPSESSID'),
         'FUNCTION': 'DELETE_MESSAGE',
         //enter target user ID
         'VAL01': mId,
     },
     error: function(error){ 
         $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error:"+ error +" <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
         return null;
     },
     success: function(json){
         if(json === false){
            $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error:Something went wrong with our messaging system. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");

            return;
         }
        
         refreshMessages();
     }
     });
}

function showEditModal(){
    var newContent = $(this).parent().contents().get(0).nodeValue;
    $("#editMessageInput").text(newContent);
    //save mId
   
    $("#editMessageSendBtn").attr("mId",$(this).parent().attr("mId"));
}

function editMessage(){
    
    $("#editMessageMdl").modal("toggle");
    $.ajax({
        url: "http://localhost/EncryptedChat/Backend/chatApi.php",
        dataType: "json",
        headers: {
            'SESSION_ID':getCookie('PHPSESSID'),
            'FUNCTION': 'CHANGE_MESSAGE',
            //enter target user ID
            'VAL01': $("#editMessageSendBtn").attr("mId"),
            'VAL02':  $("#editMessageInput").val(),
        },
        error: function(error){ 
            $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error:"+ error +" <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
            return null;
        },
        success: function(json){
            
            if(json === false || json == 0){
                $("#errorsDiv").append("<div class='alert alert-danger alert-dismissible fade show' role='alert'>"+ "Error:Something went wrong with our messaging system. <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</sp</button</div>").slideDown("slow");
               return;
            }
            refreshMessages();
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
  //checks if array are equal
  function arraysEqual(a, b) {
    if (a === b) return true;
    if (a == null || b == null) return false;
    if (a.length != b.length) return false;
    // If you don't care about the order of the elements inside
    // the array, you should sort both arrays here.
    // Please note that calling sort on an array will modify that array.
    // you might want to clone your array first.
    for (var i = 0; i < a.length; ++i) {
      if (a[i] !== b[i]) return false;
    }
    return true;
  }