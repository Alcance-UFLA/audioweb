<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1>Acessar o AudioWeb</h1>
	</header>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
			<div class="well">
				<?= View::factory('autenticacao/autenticar/form')->set('form_autenticacao', $form_autenticacao) ?>
			</div>
		</div>
	</div>
	<p class="text-center"><b><?= HTML::anchor('#TODO', '<i class="glyphicon glyphicon-plus"></i> Cadastre-se gratuitamente') ?></b></p>
</section>