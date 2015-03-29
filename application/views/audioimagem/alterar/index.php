<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::start_header() ?>
			<i class="glyphicon glyphicon-pencil"></i> Alterar imagem <small><?= HTML::chars($form_imagem['dados']['nome']) ?></small>
		<?= HTML::end_header() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('audioimagem/alterar/form')->set('form_imagem', $form_imagem) ?>
			</div>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>