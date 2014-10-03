<?php

return array(
	'nome' => array(
		'not_empty' => 'Faltou preencher o campo Nome',
		'min_length' => 'O campo Nome deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Nome deve ter o tamanho máximo :param2.',
	),
	'descricao' => array(
		'not_empty' => 'Faltou preencher o campo Descrição',
		'min_length' => 'O campo Descrição deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Descrição deve ter o tamanho máximo :param2.',
	),
	'rotulos' => array(
		'min_length' => 'O campo Rótulos deve ter o tamanho mínimo :param2.',
		'max_length' => 'O campo Rótulos deve ter o tamanho máximo :param2.',
	),
	'arquivo' => array(
		'Upload::not_empty' => 'Faltou preencher o campo Arquivo.',
		'Upload::valid' => 'Erro ao enviar o arquivo de imagem.',
		'Upload::image' => 'O campo Arquivo deve ser uma imagem.',
		'Upload::size' => 'O campo Arquivo dever ter o tamanho máximo de :param2.',
	),
	'id_tipo_imagem' => array(
		'not_emtpy' => 'Faltou preencher o campo Tipo de Imagem.'
	),
	'id_usuario' => array(
		'not_emtpy' => 'Faltou associar a imagem a um usuário.'
	),
);