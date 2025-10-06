<?php
session_start();
require 'includes/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        $erro = "E-mail não encontrado.";
    } elseif (!password_verify($senha, $usuario['senha_hash'])) {
        $erro = "Senha incorreta.";
    } elseif (!$usuario['verificado']) {
        $erro = "Conta ainda não verificada.";
    } else {
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_id'] = $usuario['id'];
        header("Location: painel.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Login - Kyrios</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .erro {
      background-color: #fdd;
      color: #900;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #f99;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <h2>Login</h2>

  <?php if ($erro): ?>
    <div class="erro"><?= $erro ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <label>E-mail:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <button type="submit">Entrar</button>
  </form>
</body>
</html>
