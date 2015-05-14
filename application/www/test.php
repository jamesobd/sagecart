<?php
$to = 'james@obdstudios.com';
$subject = 'Test Message';
$message = 'Hello, World!';
$headers = "From: example@example.com\r\n"; // Or sendmail_username@hostname by default
$result = mail($to, $subject, $message, $headers);


if($result) {
    echo "success";
} else {
    echo "failure";
}