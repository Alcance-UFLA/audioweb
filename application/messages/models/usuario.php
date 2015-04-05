<?php

return array(
	'nome' => array(
		'not_empty' => 'Faltou preencher o campo Nome',
		'min_length' => 'O campo Nome deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Nome deve ter o tamanho máximo :param2.',
	),
	'email' => array(
		'not_empty' => 'Faltou preencher o campo E-mail',
		'min_length' => 'O campo E-mail deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo E-mail deve ter o tamanho máximo :param2.',
		'email' => 'O campo E-mail deve ser um endereço de e-mail válido.',
		'unique' => 'Já existe um usuário com este e-mail.'
	),
	'senha' => array(
		'not_empty' => 'Faltou preencher o campo Senha',
		'min_length' => 'O campo Senha deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Senha deve ter o tamanho máximo :param2.'
	),
	'id_conta' => array(
		'not_emtpy' => 'Faltou associar o usuário a uma conta.'
	),
	'concordar' => array(
		'not_empty' => 'Para se cadastrar no sistema, você precisa concordar com a Licença de Uso e com a Política de Privacidade do AudioWeb.'
	)
);
