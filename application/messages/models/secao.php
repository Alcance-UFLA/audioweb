<?php

return array(
	'titulo' => array(
		'not_empty' => 'Faltou preencher o campo Título.',
		'min_length' => 'O campo Título deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Título deve ter o tamanho máximo :param2.',
	),
	'nivel' => array(
		'not_empty' => 'Faltou preencher o campo Nível.',
		'range' => 'O campo Nível possui valor inválido.'
	),
	'posicao' => array(
		'not_empty' => 'Faltou preencher o campo Posição.',
		'range' => 'O campo Posição possui valor inválido.'
	),
	'id_aula' => array(
		'not_emtpy' => 'Faltou associar a seção a uma aula.'
	),
);