<?php
require '../includes/conexao.php';
require '../includes/mailer.php';

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$endereco = $_POST['endereco'];
$senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

$codigo = rand(100000, 999999);
$expira = date('Y-m-d H:i:s', strtotime('+10 minutes'));

$stmt = $pdo->prepare("INSERT INTO usuarios 
  (nome, cpf, email, telefone, endereco, senha_hash, codigo_verificacao, codigo_expira_em) 
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$nome, $cpf, $email, $telefone, $endereco, $senha, $codigo, $expira]);

$msg = "Olá $nome,<br><br>Seu código de verificação é: <strong>$codigo</strong><br>Este código expira em 10 minutos.";
enviarEmail($email, 'Verificação de Conta - Kyrios', $msg);

echo 'Cadastro realizado. Verifique seu e-mail.';
