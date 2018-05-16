<?php

include(dirname(__FILE__)."/../../config.php");
include(dirname(__FILE__)."/../PHPMailer/src/PHPMailer.php");
include(dirname(__FILE__)."/../PHPMailer/src/Exception.php");
include(dirname(__FILE__)."/../PHPMailer/src/SMTP.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mandrill {

    public static function SendDefault($text,$html,$subject,$to,$tags){

//        $uri = 'https://mandrillapp.com/api/1.0/messages/send.json';
//
//        $postString = array(
//            "key" => $GLOBALS['mandrill_api_key'],
//            "message" => array(
//                "html" => $html,
//                "text" => $text,
//                "subject" => $subject,
//                "from_email" => $GLOBALS['mandrill_reply_email'],
//                "from_name" => $GLOBALS['name'],
//                "to" => $to,
//                "headers" => array(
//                    "Reply-To" => $GLOBALS['mandrill_reply_email']),
//                "track_opens" => true,
//                "track_clicks" => false,
//                "async" => true,
//                "auto_text" => true,
//                "tags" => $tags),
//            "async" => false);

//        $uri = 'http://email-sender.aecu.org.uy/send.php';
//
//        $postData = array(
//            "to" => $to,
//            "from" => "=?utf-8?B?" . base64_encode("Club Cannábico El Piso") . "?= <ccelpiso@gmail.com>",
//            "message" => $html,
//            "subject" => $subject);
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $uri);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
//
//        $result = curl_exec($ch);

//        $headers = "MIME-Version: 1.0" . "\r\n";
//        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//        $headers .= "From: Club Cannabico El Piso <pagos@ccelpiso.aecu.org.uy>" . "\r\n";
//        $headers .= "Reply-To: ccelpiso@gmail.com";
//
//        echo "\nEMAIL SENT: " . mail($to,$subject,$html,$headers);

        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'server.uyuyuyhost.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'administracion@elpiso.club';                 // SMTP username
            $mail->Password = 'administracion2017';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('administracion@elpiso.club', 'Club Cannabico El Piso');
            $mail->addAddress($to);     // Add a recipient
            $mail->AddReplyTo('ccelpiso@gmail.com', 'Club Cannabico El Piso');

            $mail->Subject = $subject;
            $mail->Body    = $html;
            $response = $mail->send();



            echo 'Message processed: ' . $response;

        } catch (Exception $e) {
            //echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }



    private static function _PrepareAttachmentsForSending($attachments){
        $keys = array_keys($attachments);
        for($i=0;$i<count($keys);$i++){
            if($attachments[$keys[$i]]['type'] == "text/plain" || $attachments[$keys[$i]]['type'] == "text/x-log"){
                $attachments[$keys[$i]]['content'] = base64_encode($attachments[$keys[$i]]['content']);
            }
        }
        return $attachments;
    }
}