<?php
error_reporting(E_ALL ^ E_DEPRECATED);
include 'PHPMailers/PHPMailerAutoload.php';

if (isset($_POST['submit']))
{
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug   = 0; // หากต้องการแสดงผลว่ามี error อะไรให้ใส่ 1 , 2 , 3 ตามต้องการ
    $mail->Debugoutput = 'html';
    $mail->Host        = "smtp.gmail.com";
    $mail->Port        = 587;
    $mail->SMTPSecure  = 'tls';
    $mail->SMTPAuth    = true;
    $mail->CharSet     = "UTF-8";
    $mail->Username    = "wooddy2531@gmail.com";
    $mail->Password    = "pigwood8";

    $mail->setFrom('wooddy2531@gmail.com', 'sarawut naimrat');
    $mail->addAddress("wooddy2531@gmail.com", "sarawut naimrat");

    $mail->Subject = "=?utf-8?B?" . base64_encode("แจ้งลิงค์เปลี่ยนรหัสผ่านจากระบบ Stock") . "?=";
    $mail->msgHTML("ท่านสามารถคลิกลิงค์ฺเปลี่ยนรหัสผ่านได้");

    // Send email
    if (!$mail->send())
    {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;

    }
    else
    {
        echo 'Message has been sent';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Send Mail</title>
</head>

<body>
    <h1>Test Send Mail wit PHPMailer</h1>
    <form action="sendmail_phpmailer.php" method="post">
        <input type="submit" value="submit" name="submit">
    </form>
</body>

</html>
