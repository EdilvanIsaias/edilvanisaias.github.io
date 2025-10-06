<?php
session_start();
require 'includes/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if (!$usuario) {
            $erro = "Usuário não cadastrado.";
        } elseif (!password_verify($senha, $usuario['senha_hash'])) {
            $erro = "Senha incorreta.";
        } elseif (!$usuario['verificado']) {
            $erro = "Conta não verificada. Verifique seu e-mail.";
        } else {
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_id'] = $usuario['id'];
            header("Location: painel.php");
            exit;
        }
    }
}
?>
