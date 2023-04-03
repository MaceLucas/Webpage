<?php
  $receiving_email_address = 'gaurabpandey03@gmail.com';
  $messages_file = 'message.txt';
  
  if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
  } else {
    die('Unable to load the "PHP Email Form" library!');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address; 
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];
  
  $contact->add_message($_POST['name'], 'From');
  $contact->add_message($_POST['email'], 'Email');
  $contact->add_message($_POST['message'], 'Message', 10);

  $message = $contact->get_message();

  if (file_put_contents($messages_file, $message . PHP_EOL, FILE_APPEND | LOCK_EX) === false) {
    die('Failed to write message to file!');
  }

  if (chmod($messages_file, 0600) === false) {
    die('Failed to set permissions on messages file!');
  }

  echo $contact->send();
?>
