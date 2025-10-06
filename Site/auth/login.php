<?php
session_start();
require '../includes/conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if (!$usuario || !password_verify($senha, $usuario['senha_hash'])) {
  die('Credenciais inválidas');
}

if (!$usuario['verificado']) {
  die('Conta não verificada');
}

$_SESSION['usuario'] = [
  'id' => $usuario['id'],
  'nome' => $usuario['nome'],
  'email' => $usuario['email']
];

echo 'Login realizado com sucesso';
