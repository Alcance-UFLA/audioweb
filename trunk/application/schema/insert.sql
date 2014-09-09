INSERT INTO licencas (id_licenca, nome) VALUES
  (1, 'Licença de Administrador'),
  (2, 'Licença Pública');

INSERT INTO contas (id_conta, id_licenca) VALUES
  (1, 1);

INSERT INTO usuarios (nome, email, senha, id_conta) VALUES
  ('Administrador', 'admin@audioweb.com.br', '78be0f381152733304d0102195899ea793c2d498f8bf25344b107ee792f3df88', 1);

INSERT INTO restricoes_aplicacao (chave, nome, valor_padrao) VALUES
  ('CONTA.LIMITE_USUARIOS', 'Limite de usuários na conta', '1'),
  ('AUDIOIMAGEM.CADASTRAR_IMAGEM', 'Cadastrar/Alterar imagens no AudioImagem', 'true'),
  ('AUDIOIMAGEM.VISUALIZAR_IMAGEM', 'Visualizar imagem no AudioImagem', 'true');