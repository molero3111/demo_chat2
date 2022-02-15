<?php
  require __DIR__ . '/vendor/autoload.php';

  $options = array(
    'cluster' => 'us2',
    'useTLS' => true
  );
  $pusher = new Pusher\Pusher(
    '0416e92d345ab6eea214',
    '8df4677012fe7dd78b9d',
    '1344149',
    $options
  );
  $chat = json_decode(file_get_contents('php://input'));
  
  $data['message'] = $chat->message;
  $pusher->trigger('my-channel', 'my-event', $data);
?>