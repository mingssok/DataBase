<?php

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */



include "PHPMailer.php";
include "SMTP.php";


//Create a new PHPMailer instance
$mail = new PHPMailer();

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// SMTP::DEBUG_OFF = off (for production use)
// SMTP::DEBUG_CLIENT = client messages
// SMTP::DEBUG_SERVER = client and server messages
$mail->SMTPDebug = SMTP::DEBUG_SERVER;

//Set the hostname of the mail server
$mail->Host = 'smtp.naver.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 465;

//Set the encryption mechanism to use - STARTTLS or SMTPS
$mail->SMTPSecure = "ssl";

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = 'cnu8885';

//Password to use for SMTP authentication
$mail->Password = 'oksk1811!';

//Password to use for SMTP authentication
$mail->CharSet = 'UTF-8';

//Set who the message is to be sent from
$mail->setFrom('cnu8885@naver.com', 'Admin');

//Set an alternative reply-to address
$mail->addReplyTo('cnu8885@naver.com', 'Admin');

$mailAdd = $_GET['mode'];
//Set who the message is to be sent to
$mail->addAddress($mailAdd, '회원');

//Set the subject line
$mail->Subject = '[온라인도서관] 도서예약 취소 안내 메일';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML("예약하신 책을 대출하지 않아 예약이 취소되었습니다.");

//Replace the plain text body with one created manually
$mail->AltBody = '';

//Attach an image file
$mail->addAttachment('');

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}
header("Location: ../adminRESERVE.php");
