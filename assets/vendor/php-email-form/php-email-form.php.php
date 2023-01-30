<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */
$recipient_email = "danny.raj12@gmail.com";

if (isset($_POST['recaptcha-response'])) {
  $url = 'https://www.google.com/recaptcha/api/siteverify';
  $data = array(
    'secret' => '6LfhjzkkAAAAANuzqKd2oh-e1LXD_JkDRJsNY4W6',
    'response' => $_POST['recaptcha-response'],
    'remoteip' => $_SERVER['REMOTE_ADDR']
  );
  
  $options = array(
    'http' => array(
      'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
      'method'  => 'POST',
      'content' => http_build_query($data)
    )
  );
  
  $context  = stream_context_create($options);
  $response = file_get_contents($url, false, $context);
  
  $responseData = json_decode($response);
  
  if ($responseData->success) {
    $sender_name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $sender_email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

    $email_body = "Name: $sender_name\nEmail: $sender_email\n\nSubject: $subject\n\nMessage: $message";
    
    $headers = "From: $sender_name <$sender_email>";
    
    if (mail($recipient_email, $subject, $email_body, $headers)) {
      echo "OK";
    } else {
      echo "An error occurred while sending the message.";
    }
  } else {
    echo "reCAPTCHA validation failed.";
  }
} else {
  echo "No data received.";
}

?>
