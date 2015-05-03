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
	'rotulos' => array(
		'min_length' => 'O campo Rótulos deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Rótulos deve ter o tamanho máximo :param2.',
	),
	'id_usuario' => array(
		'not_emtpy' => 'Faltou associar a imagem a um usuário.'
	),
);