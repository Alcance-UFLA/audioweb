<?php

/// ACTIONS ESPECIFICAS

// Default
Route::set('default', '')
	->defaults(array(
		'directory'  => '',
		'controller' => 'apresentacao',
		'action'     => 'index'
	));

// Pagina principal
Route::set('principal', 'principal')
	->defaults(array(
		'directory'  => '',
		'controller' => 'Principal',
		'action'     => 'index'
	));

// Pagina de politica de privacidade
Route::set('politica_de_privacidade', 'politica-de-privacidade')
	->defaults(array(
		'directory'  => 'Informacoes',
		'controller' => 'Politicaprivacidade',
		'action'     => 'index'
	));

// Pagina que exibe uma imagem do AudioImagem
Route::set('exibir_imagem', 'imagens/<conta>/<nome>(/<tamanho>)', array('conta' => '\d+', 'nome' => '[^\/]+', 'tamanho' => '\d+x\d+'))
	->defaults(array(
		'directory'  => 'Audioimagem',
		'controller' => 'Imagem',
		'action'     => 'index',
		'tamanho'    => '0x0'
	));

// Listar secoes de uma aula
Route::set('listar_secoes', 'audioaula/<id_aula>/secoes(/listar(/<action>))', array('id_aula' => '\d+'))
	->defaults(array(
		'directory'  => 'Audioaula/Secoes',
		'controller' => 'Listar',
		'action'     => 'index'
	));

// Inserir secao de uma aula
Route::set('inserir_secao', 'audioaula/<id_aula>/secoes/inserir(/<action>)', array('id_aula' => '\d+'))
	->defaults(array(
		'directory'  => 'Audioaula/Secoes',
		'controller' => 'Inserir',
		'action'     => 'index'
	));

// Alterar secao de uma aula
Route::set('alterar_secao', 'audioaula/<id_aula>/secoes/<id_secao>/alterar(/<action>)', array('id_aula' => '\d+', 'id_secao' => '\d+'))
	->defaults(array(
		'directory'  => 'Audioaula/Secoes',
		'controller' => 'Alterar',
		'action'     => 'index'
	));

// Inserir texto de uma secao
Route::set('inserir_texto_secao', 'audioaula/<id_aula>/secoes/<id_secao>/inserirtexto(/<action>)', array('id_aula' => '\d+', 'id_secao' => '\d+'))
	->defaults(array(
		'directory'  => 'Audioaula/Secoes/Textos',
		'controller' => 'Inserir',
		'action'     => 'index'
	));

// Inserir imagem de uma secao
Route::set('inserir_imagem_secao', 'audioaula/<id_aula>/secoes/<id_secao>/inseririmagem(/<action>)', array('id_aula' => '\d+', 'id_secao' => '\d+'))
	->defaults(array(
		'directory'  => 'Audioaula/Secoes/Imagens',
		'controller' => 'Inserir',
		'action'     => 'index'
	));

// Inserir formula de uma secao
Route::set('inserir_formula_secao', 'audioaula/<id_aula>/secoes/<id_secao>/inserirformula(/<action>)', array('id_aula' => '\d+', 'id_secao' => '\d+'))
	->defaults(array(
		'directory'  => 'Audioaula/Secoes/Formulas',
		'controller' => 'Inserir',
		'action'     => 'index'
	));

/// ACTIONS GENERICAS

// Listar registros recebendo a pagina
Route::set('listar', '<directory>(/listar(/p<pagina>(/<action>(/<opcao1>(/<opcao2>(/<opcao3>))))))', array('pagina' => '\d+', 'opcao1' => '[^\/]+', 'opcao2' => '[^\/]+', 'opcao3' => '[^\/]+'))
	->defaults(array(
		'controller' => 'Listar',
		'action'     => 'index',
		'pagina'     => 0,
		'opcao1'     => '',
		'opcao2'     => '',
		'opcao3'     => ''
	));

// Acao sobre um registro recebendo ID
Route::set('acao_id', '<directory>/<id>(/<controller>(/<action>(/<opcao1>(/<opcao2>(/<opcao3>)))))', array('id' => '\d+', 'opcao1' => '[^\/]+', 'opcao2' => '[^\/]+', 'opcao3' => '[^\/]+'))
	->defaults(array(
		'controller' => 'Exibir',
		'action'     => 'index',
		'opcao1'     => '',
		'opcao2'     => '',
		'opcao3'     => ''
	));

// Acao que nao recebe ID
Route::set('acao_padrao', '<directory>/<controller>(/<action>(/<opcao1>(/<opcao2>(/<opcao3>))))', array('opcao1' => '[^\/]+', 'opcao2' => '[^\/]+', 'opcao3' => '[^\/]+'))
	->defaults(array(
		'action'     => 'index',
		'opcao1'     => '',
		'opcao2'     => '',
		'opcao3'     => ''
	));
