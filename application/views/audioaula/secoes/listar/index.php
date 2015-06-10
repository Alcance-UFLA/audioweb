<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::start_header(array('id' => 'titulo-principal')) ?>
			<i class="glyphicon glyphicon-education"></i> Preparar Aula
			<small><?= HTML::chars($aula['nome']) ?></small>
		<?= HTML::end_header() ?>
		<?= HTML::start_help() ?>
			<p>Página para preparar uma aula, adicionando suas seções.</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?php if (!empty($secoes['lista'])): ?>
	<?= View::factory('audioaula/secoes/listar/lista')->set('secoes', $secoes)->set('aula', $aula) ?>
	<?php else: ?>
	<p class="lead">Nenhum conteúdo nesta aula.</p>
	<?php endif ?>

	<footer class="well">
		<span class="sr-only">Operações sobre seções de aulas:</span>
		<a class="btn btn-default btn-lg" href="<?= Route::url('inserir_secao', array('id_aula' => $aula['id_aula'])) ?>"><i class="glyphicon glyphicon-plus"></i> Inserir Seção</a>
		<span class="sr-only">,</span>&nbsp;
		<a class="btn btn-default btn-lg" href="<?= Route::url('listar', array('directory' => 'audioaula')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a lista de aulas</span></a>
	</footer>
</section>
<?php HTML::end_block() ?>
