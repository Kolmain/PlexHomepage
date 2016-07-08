<?php
if( isset($_POST) ){
    
    $postData = $_POST;
    $mailgun = sendMailgun($postData);
    
    if($mailgun) {
    echo "Great success.";
  } else {
    echo "Mailgun did not connect properly.";
  }
}

function sendMailgun($data) {
 
  $api_key = '';
  $api_domain = '';
  $send_to = '';
    
    // sumbission data
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        $date = date('d/m/Y');
        $time = date('H:i:s');
    
    // form data
        $postcontent = $data['data'];
        $reply = $data['senderAddress'];    
 
  $messageBody = "{$postcontent}
                <p>This message was sent from {$ipaddress} on {$date} at {$time}</p>";
 
  $config = array();
  $config['api_key'] = $api_key;
  $config['api_url'] = 'https://api.mailgun.net/v2/'.$api_domain.'/messages';
 
  $message = array();
  $message['from'] = $reply;
  $message['to'] = $send_to;
  $message['h:Reply-To'] = $reply;
  $message['subject'] = "Issue Report";
  $message['html'] = $messageBody;
 
  $curl = curl_init();
 
  curl_setopt($curl, CURLOPT_URL, $config['api_url']);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($curl, CURLOPT_USERPWD, "api:{$config['api_key']}");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_POST, true); 
  curl_setopt($curl, CURLOPT_POSTFIELDS,$message);
 
  $result = curl_exec($curl);
 
  curl_close($curl);
  return $result;
 
}



?>