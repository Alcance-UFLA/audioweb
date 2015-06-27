INSERT INTO licencas (id_licenca, nome) VALUES
  (1, 'Licença de Administrador'),
  (2, 'Licença Pública');

INSERT INTO contas (id_conta, id_licenca) VALUES
  (1, 1);

INSERT INTO usuarios (nome, email, senha, id_conta) VALUES
  ('Administrador', 'admin@audioweb.com.br', '78be0f381152733304d0102195899ea793c2d498f8bf25344b107ee792f3df88', 1);

INSERT INTO publicos_alvos (nome) VALUES
  ('crianças'),
  ('jovens'),
  ('adultos'),
  ('ensino fundamental'),
  ('ensino médio'),
  ('ensino superior');

INSERT INTO tipos_imagens (nome) VALUES
  ('foto'),
  ('desenho'),
  ('diagrama'),
  ('gráfico'),
  ('fórmula'),
  ('outro');

INSERT INTO restricoes_aplicacao (chave, nome, valor_padrao) VALUES
  ('CONTA.LIMITE_USUARIOS', 'Limite de usuários na conta', '1'),
  ('AUDIOIMAGEM.CADASTRAR_IMAGEM', 'Cadastrar/Alterar imagens no AudioImagem', 'true'),
  ('AUDIOIMAGEM.VISUALIZAR_IMAGEM', 'Visualizar imagem no AudioImagem', 'true');

INSERT INTO operacoes (chave, nome, tecla_padrao, shift, alt, ctrl) VALUES
  ('alternar_modo_exibicao', 'Muda modo de exibição da imagem: ou cego, ou vidente.', 74, FALSE, TRUE, FALSE),
  ('falar_nome_imagem', 'Descrição curta da imagem.', 90, FALSE, TRUE, FALSE),
  ('falar_descricao_imagem', 'Descrição longa da imagem.', 87, FALSE, TRUE, FALSE),
  ('falar_nome_regiao', 'Descrição curta da área marcada.', 90, FALSE, FALSE, FALSE),
  ('falar_descricao_regiao', 'Descrição longa da área marcada.', 87, FALSE, FALSE, FALSE),
  ('falar_posicao', 'Posição do cursor dentro ou fora da imagem.', 80, FALSE, TRUE, FALSE),
  ('parar_bip', 'Pára o bip momentaneamente.', 17, FALSE, FALSE, TRUE),
  ('falar_ajuda', 'Ajuda.', 65, FALSE, TRUE, FALSE);
