CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  cpf VARCHAR(14) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  telefone VARCHAR(20),
  endereco TEXT,
  senha_hash VARCHAR(255) NOT NULL,
  verificado BOOLEAN DEFAULT FALSE,
  codigo_verificacao VARCHAR(10),
  codigo_expira_em DATETIME,
  criado_em DATETIME DEFAULT CURRENT_TIMESTAMP
);
