<?php
require 'includes/conexao.php';

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $codigo = rand(100000, 999999);
    $expira = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    $verifica = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? OR cpf = ?");
    $verifica->execute([$email, $cpf]);

    if ($verifica->rowCount() > 0) {
        $erro = "E-mail ou CPF já cadastrado.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, cpf, email, telefone, endereco, senha_hash, codigo_verificacao, codigo_expira_em) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$nome, $cpf, $email, $telefone, $endereco, $senha_hash, $codigo, $expira])) {
            // Enviar o código por e-mail (simples)
            mail($email, "Código de Verificação", "Seu código é: $codigo");
            $sucesso = "Cadastro realizado! Verifique seu e-mail para ativar a conta.";
        } else {
            $erro = "Erro ao cadastrar. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - Kyrios</title>
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
    .sucesso {
      background-color: #dfd;
      color: #060;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #9f9;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <h2>Cadastro</h2>

  <?php if ($erro): ?>
    <div class="erro"><?= $erro ?></div>
  <?php elseif ($sucesso): ?>
    <div class="sucesso"><?= $sucesso ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <label>Nome:</label><br>
    <input type="text" name="nome" required><br><br>

    <label>CPF:</label><br>
    <input type="text" name="cpf" required><br><br>

    <label>E-mail:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone" required><br><br>

    <label>Endereço:</label><br>
    <input type="text" name="endereco" required><br><br>

    <label>Senha:</label><br>
    <input type="password" name="senha" required><br><br>

    <button type="submit">Cadastrar</button>
  </form>
</body>
</html>
