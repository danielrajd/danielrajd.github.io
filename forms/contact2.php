<?php

if(isset($_POST['submit'])) {
  // Get form values
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Validate form inputs
  if(empty($name) || empty($email) || empty($message)) {
    echo "Please fill all the required fields.";
    exit;
  }

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email address.";
    exit;
  }

  // Set recipient email
  $to = "danny.raj12@gmail.com";
  // Set subject
  $subject = "Contact form submission from $name";
  // Build message
  $message = "Name: $name\n";
  $message .= "Email: $email\n\n";
  $message .= "Message:\n$message";

  // Set headers
  $headers = "From: $name <$email>\r\n";
  $headers .= "Reply-To: $email\r\n";

  // Send email
  if(mail($to, $subject, $message, $headers)) {
    echo "Your message has been sent successfully!";
  } else {
    echo "Failed to send your message. Please try again later.";
  }

} else {
  echo "Invalid request. Please try again later.";
}

?>
