<?php
$to = 'james@obdstudios.com';
$subject = 'Test Message';
$message = 'Hello, World!';
$headers = "From: noreply@sagecart.org\r\n"; // Or sendmail_username@hostname by default
mail($to, $subject, $message, $headers);
