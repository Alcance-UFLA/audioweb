<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-pencil"></i> Alterar imagem <small><?= HTML::chars($form_imagem['dados']['nome']) ?></small></h1>
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