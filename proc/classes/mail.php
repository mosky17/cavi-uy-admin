<?php
/**
 * Coded by Mosky
 * https://github.com/mosky17
 */

include(dirname(__FILE__)."/../../config.php");
include(dirname(__FILE__)."/../PHPMailer/src/PHPMailer.php");
include(dirname(__FILE__)."/../PHPMailer/src/Exception.php");
include(dirname(__FILE__)."/../PHPMailer/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail {

    public static function SendDefault($html,$subject,$to){

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = '';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '';                 // SMTP username
            $mail->Password = '';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('', 'CAVI');
            $mail->addAddress($to);     // Add a recipient
            $mail->AddReplyTo('', 'CAVI');

            $mail->Subject = $subject;
            $mail->Body    = $html;
            $response = $mail->send();



            echo 'Message processed: ' . $response;

        } catch (Exception $e) {
            //echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}