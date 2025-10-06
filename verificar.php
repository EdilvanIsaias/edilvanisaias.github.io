<?php
require 'includes/conexao.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $codigo = $_POST['codigo'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? AND codigo_verificacao = ?");
    $stmt->execute([$email, $codigo]);
    $usuario = $stmt->fetch();

    if ($usuario && strtotime($usuario['codigo_expira_em']) >= time()) {
        $update = $pdo->prepare("UPDATE usuarios SET verificado = 1, codigo_verificacao = NULL, codigo_expira_em = NULL WHERE id = ?");
        $update->execute([$usuario['id']]);
        $mensagem = "Conta verificada com sucesso!";
    } else {
        $mensagem = "Código inválido ou expirado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Verificar Conta - Kyrios</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Verificação de Conta</h2>

  <?php if ($mensagem): ?>
    <p><?= $mensagem ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <label>E-mail:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Código de verificação:</label><br>
    <input type="text" name="codigo" required><br><br>

    <button type="submit">Verificar</button>
  </form>
</body>
</html>
