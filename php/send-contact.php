<?php

// Get the form values from POST
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

// Define the recipient email and subject
$to = "bijuaryal17@gmail.com"; // Replace with the recipient's email address
$subject = "New Contact Form Submission";

// Create the message content
$body = "You have received a new message from the contact form on your website.\n\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Phone: $phone\n";
$body .= "Message: \n$message\n";

// Additional headers
$headers = "From: $email\r\n"; // Set the sender's email
$headers .= "Reply-To: $email\r\n"; // Set reply-to email

// Send the email
if (mail($to, $subject, $body, $headers)) {
    echo "success";
} else {
    echo "Failed to send email.";
}

?>
