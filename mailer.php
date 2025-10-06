<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // composer install aqui

function enviarEmail($destinatario, $assunto, $mensagem) {
  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.seuservidor.com';  // SMTP do seu provedor
    $mail->SMTPAuth = true;
    $mail->Username = 'seuemail@dominio.com';
    $mail->Password = 'suasenha';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('seuemail@dominio.com', 'Kyrios Clinical Services');
    $mail->addAddress($destinatario);
    $mail->isHTML(true);
    $mail->Subject = $assunto;
    $mail->Body = $mensagem;

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}
