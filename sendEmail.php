<?php

    include 'token.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    $response = new stdClass();
    if (isset($_POST['token']) && $_POST['token'] == $_SESSION['csrf_token'] && isset($_POST["purpose"])){
        regenerateToken();
        if (isset($_POST['link']) && isset($_POST['name'])){
            if ($_POST["purpose"] == "approval"){
                sendMail($mail,"jfcgraphicsllc@gmail.com","Approved Project","The customer has approved the project! <b>Link is: <a href=\"".$_POST['link']."\">".$_POST['link']."</a> </b> <br> <b> Name is: ".$_POST["name"]."</b>",$response,"Project Is Approved");
            }elseif ($_POST["purpose"] == "comment" && isset($_POST['comment']) && $_POST['comment'] != ""){
                sendMail($mail,"jfcgraphicsllc@gmail.com","Commented Project","The customer has commented the project! <b>Link is: <a href=\"".$_POST['link']."\">".$_POST['link']."</a> </b> <br> <b> Name is: ".$_POST["name"]."</b> <br> <b> Comment is: ".$_POST['comment']."</b>",$response,"Project Is Commented");
            }
        }
        
        echo json_encode($response);
    }

    function sendMail($mail,$EMAIL,$SUBJECT,$MESSAGE,$response,$RESULT){
        try {
            //Server settings
            $account = parse_ini_file('account.ini');
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $account["username"];                     //SMTP username
            $mail->Password   = $account["password"];                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('from@gmail.com', 'Mailer');
            $mail->addAddress($EMAIL, 'Receiver');     //Add a recipient
            $mail->addReplyTo('jfcgraphicsllc@gmail.com', 'JFC Graphics');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $SUBJECT;
            $mail->Body    = $MESSAGE;

            $mail->send();

            $response->finished="true";
            $response->result=$RESULT;
        } catch (Exception $e) {
            $response->finished="false";
            $response->result="Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>