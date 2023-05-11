<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form fields and sanitize input
  $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING);
  $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

  // Validate input
  if ( empty($name) || empty($message) || empty($subject) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Set a 400 (bad request) response code and exit
    http_response_code(400);
    echo 'Please fill out all fields correctly.';
    exit;
  }

  // Set the recipient email address
  $recipient = gaurabpandey03@gmail.com';

  // Set the email subject
  $email_subject = "New cweb response from $name";

  // Build the email content
  $email_content = "Name: $name\n";
  $email_content .= "Email: $email\n\n";
  $email_content .= "Subject: $subject\n\n";
  $email_content .= "Message:\n$message\n";

  // Build the email headers
  $email_headers = "From: $name <$email>\r\n";
  $email_headers .= "Reply-To: $email\r\n";
  $email_headers .= "Content-Type: text/plain; charset=utf-8\r\n";
  $email_headers .= "X-Mailer: PHP/" . phpversion();

  // Send the email
  if (mail($recipient, $email_subject, $email_content, $email_headers)) {
    // Set a 200 (okay) response code
    http_response_code(200);
    echo 'Thank You! Your message has been sent.';
  } else {
    // Set a 500 (internal server error) response code
    http_response_code(500);
    echo 'Oops! Something went wrong and we couldn\'t send your message.';
  }

} else {
  // Not a POST request, set a 403 (forbidden) response code
  http_response_code(403);
  echo 'There was a problem with your submission, please try again.';
}
