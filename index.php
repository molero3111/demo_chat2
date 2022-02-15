<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>  
  
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js" type="text/javascript" ></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script> 
 <style>
    .messages_display {height: 300px; overflow: auto;}     
    .messages_display .message_item {padding: 0; margin: 0; }      
    .bg-danger {padding: 10px;}
  </style>
</head>
<body>
<div class = "container">      
    <div class = "col-md-6 chat_box mt-4">                      
        <div class = "form-control messages_display"></div>        
        <br />                     
        <div class = "form-group">             
            <label>Name</label>            
            <input type = "text" class = "input_name form-control" placeholder = "Name" />         
        </div>                     
        <div class = "form-group">             
            <label>Message</label>             
            <textarea class = "input_message form-control" placeholder = "Message"></textarea>         
        </div>                     
        <div class = "form-group input_send_holder">               
            <input type = "submit" value = "Send" class = "btn btn-primary input_send" />          
        </div>                 
    </div> 
</div>

<script type="text/javascript">        
// Enter your own Pusher App key
var pusher = new Pusher('0416e92d345ab6eea214', {
    cluster: 'us2',
    encrypted: true
});

// Enter a unique channel you wish your users to be subscribed in.
var channel = pusher.subscribe('test');
channel.bind('my-event', function(data) { 
  
   console.log('new message found', data);
    // Add the new message to the container
    $('.messages_display').append('<p class = "message_item">' + data.message + '</p>');
    // Display the send button
    $('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary input_send" />');
    // Scroll to the bottom of the container when a new message becomes available
    $(".messages_display").scrollTop($(".messages_display")[0].scrollHeight);
});
//https://www.cloudways.com/blog/real-time-chat-app-php/
//https://carlofontanos.com/building-a-real-time-chat-application-using-pusher/
// var channel = pusher.subscribe('test');
//     channel.bind('my-event', function(data) { 

//       console.log('message found', data.message);
//       alert( data.message);
//     });

// AJAX request
function ajaxCall(ajax_url, ajax_data) {
    $.ajax({
        type: "POST",
        url: ajax_url,
        contentType: 'application/json; charset=utf-8',
        dataType: "json",
        data: JSON.stringify(ajax_data),
        success: function(response) {
            console.log('success',response);
        },error: function(response) {
            console.log(response);
        }
    });
}

// Trigger for the Enter key when clicked.
$.fn.enterKey = function(fnc) {
    return this.each(function() {
        $(this).keypress(function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if (keycode == '13') {
                fnc.call(this, ev);
            }
        });
    });
}

// Send the Message
$('body').on('click', '.chat_box .input_send', function(e) {
    e.preventDefault();
   
    var message = $('.chat_box .input_message').val();
    var name = $('.chat_box .input_name').val();
   
    // Validate Name field
    if (name === '') {
        bootbox.alert('<br /><p class = "bg-danger">Please enter a Name.</p>');
   
    } else if (message !== '') {
        // Define ajax data
        var chat_message = {
            name: $('.chat_box .input_name').val(),
            message: '<strong>' + $('.chat_box .input_name').val() + '</strong>: ' + message
        }

        // Send the message to the server
        ajaxCall('message_relay.php', chat_message);
       
        // Clear the message input field
        $('.chat_box .input_message').val('');
        // Show a loading image while sending
        //$('.input_send_holder').html('<input type = "submit" value = "Send" class = "btn btn-primary" disabled /> &nbsp;<img src = "loading.gif" />');
    }
});

// Send the message when enter key is clicked
$('.chat_box .input_message').enterKey(function(e) {
    e.preventDefault();
    $('.chat_box .input_send').click();
});
</script>
  
</body>
</html>