$(document).ready(function () {
    
    $(".users").click(function() {
        updateChatScreen(this);
     });
});

//only for testing

/**
 * Updates the chat selection
 */
function updateChatScreen(obj) {
    console.log($(obj).attr("username"));


}