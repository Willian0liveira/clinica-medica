<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
require 'config.php'; // <-- AQUI É CARREGADO O ARQUIVO COM AS CREDENCIAIS

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nome     = $_POST["nome"];
  $telefone = $_POST["telefone"];
  $email    = $_POST["email"];
  $mensagem = $_POST["mensagem"];

  $mail = new PHPMailer(true);

  try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port       = SMTP_PORT;

    // Remetente e destinatário
    $mail->setFrom(SMTP_USER, 'Mensagem do site');
    $mail->addAddress('contato@clinicamedica.com.br');

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Novo contato via formulario do site - Clinica Medica';

    $conteudo = '
<html>
<body style="background-color:#e55c00; color:white; font-family:Arial, sans-serif; padding:40px 20px;">
  <div style="max-width:600px; margin:auto;">
    <div style="display:flex; align-items:center; gap:15px; margin-bottom:30px;">
      <img src="https://clinicamedica.com.br/assets/img/logo.png" alt="Logo" style="height:50px;">
      <h1 style="font-size:22px; margin:0;">Clínica Medica</h1>
    </div>

    <div style="display:flex; align-items:center; gap:15px; margin-bottom:30px;">
     <h1 style="font-size:22px; margin:0;">Olá, acabamos de receber uma nova mensagem pelo site. Os dados estão abaixo.</h1>
    </div>

    <table width="100%" cellpadding="5" cellspacing="0" style="margin-top:20px;">
      <tr>
        <td style="font-weight:bold; width:140px;">Nome:</td>
        <td>' . htmlspecialchars($nome) . '</td>
      </tr>
      <tr>
        <td style="font-weight:bold;">Telefone | WhatsApp:</td>
        <td>' . htmlspecialchars($telefone) . '</td>
      </tr>
      <tr>
        <td style="font-weight:bold;">E-mail:</td>
        <td><a href="mailto:' . htmlspecialchars($email) . '" style="color:white; text-decoration:none;">' . htmlspecialchars($email) . '</a></td>
      </tr>
      <tr>
        <td style="font-weight:bold;">Mensagem do cliente:</td>
        <td>' . nl2br(htmlspecialchars($mensagem)) . '</td>
      </tr>
    </table>
  </div>
</body>
</html>
';
    $mail->Body = $conteudo;
    $mail->AltBody = strip_tags($conteudo);

    $mail->send();
    header("Location: congrats.html");
    exit;

  } catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
  }
}
?>