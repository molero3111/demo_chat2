<?php

// require('lib/Pusher.php');
require __DIR__ . '/vendor/autoload.php';
use Pusher\Pusher;
// Change the following with your app details:
// Create your own pusher account @ www.pusher.com
// $app_id = "1344149";
// $app_key = "0416e92d345ab6eea214";
// $app_secret = "8df4677012fe7dd78b9d";
// $pusher = new Pusher($app_key, $app_secret, $app_id, array(

//     'cluster' => 'us2',
 
//     'encrypted' => true
 
//   )
// );
$options = array(
    'cluster' => 'us2',
    'useTLS' => true
  );
  $pusher = new Pusher(
    '0416e92d345ab6eea214',
    '8df4677012fe7dd78b9d',
    '1344149',
    $options
  );
  
$chat = json_decode(file_get_contents('php://input'));

// Check the receive message

if(isset($chat->message) && !empty($chat->message)) {   

    // Return the received message

    if($pusher->trigger('test', 'my-event', array('message' => $chat->message))) {              
        echo json_encode($chat);    
    } else {       
        echo ' error';  
    }
}else { echo ' no message';}

?>