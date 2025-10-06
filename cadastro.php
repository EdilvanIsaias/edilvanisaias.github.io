// Validações básicas
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erro = "E-mail inválido.";
} elseif (!preg_match('/^[0-9]{8,}$/', $telefone)) {
    $erro = "Telefone inválido. Use apenas números com ao menos 8 dígitos.";
} elseif (!preg_match('/^(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{6,}$/', $senha)) {
    $erro = "Senha fraca. Use no mínimo 6 caracteres, uma letra maiúscula e um caractere especial.";
} else {
    // prossegue com o cadastro
}
