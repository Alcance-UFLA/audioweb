<?php

return array(
	'nome' => array(
		'not_empty' => 'Faltou preencher o campo Nome.',
		'min_length' => 'O campo Nome deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Nome deve ter o tamanho máximo :param2.',
	),
	'descricao' => array(
		'not_empty' => 'Faltou preencher o campo Descrição.',
		'min_length' => 'O campo Descrição deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Descrição deve ter o tamanho máximo :param2.',
	),
	'posicao' => array(
		'not_empty' => 'Faltou preencher o campo Posição.',
		'numeric' => 'O campo Posição deve ser numérico.',
	),
	'tipo_regiao' => array(
		'not_empty' => 'Faltou preencher o campo Tipo de região.',
		'regex' => 'Tipo de região inválido.',
	),
	'coordenadas' => array(
		'not_empty' => 'Faltou preencher o campo Coordenadas.',
		'regex' => 'Coordenadas inválidas.',
	),
	'id_usuario' => array(
		'not_emtpy' => 'Faltou associar a imagem a um usuário.'
	),
);