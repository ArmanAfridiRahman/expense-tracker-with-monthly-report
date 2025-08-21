<?php

namespace App\Services;

class MailService
{
     public function send($to, $subject, $body)
     {
          $mail = new PHPMailer(true);

          $mail->isSMTP();
          $mail->Host = env('MAIL_HOST');
          $mail->SMTPAuth = true;
          $mail->Username = env('MAIL_USERNAME');
          $mail->Password = env('MAIL_PASSWORD');
          $mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');
          $mail->Port = env('MAIL_PORT', 587);

          $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
          $mail->addAddress($to);
          $mail->Subject = $subject;
          $mail->Body = $body;
          $mail->isHTML(true);

          return $mail->send();
     }
}
