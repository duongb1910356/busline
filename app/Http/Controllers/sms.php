<?php 
 
// Update the path below to your autoload.php, 
// see https://getcomposer.org/doc/01-basic-usage.md 
require_once '/path/to/vendor/autoload.php'; 
 
use Twilio\Rest\Client; 
 
$sid    = "AC6d1223daf1529e4f573a8e8430fafc7e"; 
$token  = "[AuthToken]"; 
$twilio = new Client($sid, $token); 
 
$message = $twilio->messages 
                  ->create("+84832645549", // to 
                           array(        
                               "body" => "Your message" 
                           ) 
                  ); 
 
print($message->sid);