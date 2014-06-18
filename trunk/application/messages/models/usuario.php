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
		'unique' => 'Já existe um usuário com este e-mail.'
	),
	'senha' => array(
		'not_empty' => 'Faltou preencher o campo Senha'
	),
);