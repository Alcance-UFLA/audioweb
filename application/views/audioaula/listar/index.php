<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::start_header(array('id' => 'titulo-principal')) ?>
			<i class="glyphicon glyphicon-education"></i> Lista de Aulas
		<?= HTML::end_header() ?>
		<?= HTML::start_help() ?>
			<p>Página com uma lista de aulas preparadas.</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?php if ($aulas['paginacao']['total_registros']): ?>
	<?= View::factory('audioaula/listar/lista')->set('aulas', $aulas) ?>
	<div class="text-center">
		<?= Helper_Paginacao::exibir($aulas['paginacao']) ?>
	</div>
	<?php else: ?>
	<p class="lead">Nenhuma aula cadastrada.</p>
	<?php endif ?>
	<footer class="well">
		<span class="sr-only">Operações sobre aulas:</span>
		<a class="btn btn-success btn-lg" href="<?= Route::url('acao_padrao', array('directory' => 'audioaula', 'controller' => 'inserir')) ?>"><i class="glyphicon glyphicon-plus"></i> Inserir Aula</a>
		<span class="sr-only">,</span>&nbsp;
		<a class="btn btn-default btn-lg" href="<?= Route::url('principal') ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a página inicial</span></a>
	</footer>
</section>
<?php HTML::end_block() ?>
