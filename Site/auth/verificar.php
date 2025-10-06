<?php
require '../includes/conexao.php';

$email = $_POST['email'];
$codigo = $_POST['codigo'];

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$usuario = $stmt->fetch();

if (!$usuario) {
  die('Usuário não encontrado');
}

if ($usuario['verificado']) {
  die('Conta já verificada');
}

if ($usuario['codigo_verificacao'] === $codigo && strtotime($usuario['codigo_expira_em']) > time()) {
  $stmt = $pdo->prepare("UPDATE usuarios SET verificado = 1 WHERE email = ?");
  $stmt->execute([$email]);
  echo 'Conta verificada com sucesso.';
} else {
  echo 'Código inválido ou expirado.';
}
