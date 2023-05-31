<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form fields and remove whitespace
  $name = strip_tags(trim($_POST['name']));
  $name = str_replace(array("\r","\n"),array(" "," "),$name);
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $subject = trim($_POST['subject']);
  $message = trim($_POST['message']);

  // Server-side validation
  if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo 'Please fill out all fields.';
    exit;
  }

  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo 'Please enter a valid email address.';
    exit;
  }

  // Set the recipient email address
  $recipient = 'gaurabpandey03@gmail.com';

  // Set the email subject
  $email_subject = "New contact form submission from $name";

  // Build the email content
  $email_content = "Name: $name\n";
  $email_content .= "Email: $email\n\n";
  $email_content .= "Subject: $subject\n\n";
  $email_content .= "Message:\n$message\n";

  // Build the email headers
  $email_headers = "From: $name <$email>";

  // Send the email
  if (mail($recipient, $email_subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo 'Thank you! Your message has been sent.';
  } else {
    http_response_code(500);
    echo 'Oops! Something went wrong and we couldn\'t send your message.';
  }
} else {
  // Not a POST request, set a 403 (forbidden) response code
  http_response_code(403);
  echo 'There was a problem with your submission, please try again.';
}
?>
