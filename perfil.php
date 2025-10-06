<?php
session_start();
require '../includes/conexao.php';

if (!isset($_SESSION['usuario'])) {
  header('Location: ../index.html');
  exit;
}

$id = $_SESSION['usuario']['id'];
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$dados = $stmt->fetch();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="UTF-8"><title>Perfil</title></head>
<body>
  <h2>Meu Perfil</h2>
  <form method="post" action="atualizar_perfil.php">
    <input type="text" name="nome" value="<?= $dados['nome'] ?>" required />
    <input type="text" name="cpf" value="<?= $dados['cpf'] ?>" readonly />
    <input type="email" name="email" value="<?= $dados['email'] ?>" required />
    <input type="text" name="telefone" value="<?= $dados['telefone'] ?>" />
    <input type="text" name="endereco" value="<?= $dados['endereco'] ?>" />
    <button type="submit">Salvar alterações</button>
  </form>
</body>
</html>
