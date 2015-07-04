<?php

return array(
	'id_imagem' => array(
		'not_empty' => 'Faltou selecionar a imagem.'
	),
	'posicao' => array(
		'not_empty' => 'Faltou preencher o campo Posição.',
		'range' => 'O campo Posição possui valor inválido.'
	),
	'id_secao' => array(
		'not_emtpy' => 'Faltou associar a imagem a uma seção.'
	),
);