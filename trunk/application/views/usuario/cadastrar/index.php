<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1>Cadastrar usuário</h1>
	</header>
	<?= Helper_Mensagens::exibir($mensagens) ?>

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('usuario/cadastrar/form')->set('form_usuario', $form_usuario) ?>
			</div>
		</div>
	</div>
</section>