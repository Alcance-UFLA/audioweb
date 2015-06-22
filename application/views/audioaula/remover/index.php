<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::start_header(array('id' => 'titulo-principal')) ?>
			<i class="glyphicon glyphicon-trash"></i> Remover Aula
			<small><?= HTML::chars($aula['nome']) ?></small>
		<?= HTML::end_header() ?>
		<?= HTML::start_help() ?>
			<p>Página para remover uma aula.</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('audioaula/remover/form')->set('aula', $aula) ?>
			</div>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>