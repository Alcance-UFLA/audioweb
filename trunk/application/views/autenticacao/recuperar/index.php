<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-lock"></i> Recuperar Acesso</h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
			<div class="well">
				<?= View::factory('autenticacao/recuperar/form')->set('form_recuperar', $form_recuperar) ?>
			</div>
		</div>
	</div>
</section>