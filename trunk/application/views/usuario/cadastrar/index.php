<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-plus"></i> Cadastrar usuário</h1>
	</header>

	<nav>
		<span class="sr-only">Navegação:</span>
		<ol class="breadcrumb">
			<li><a href="<?= Route::url('default') ?>">Início</a></li>
			<li class="active">Cadastrar usuário</li>
		</ol>
	</nav>

	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('usuario/cadastrar/form')->set('form_usuario', $form_usuario) ?>
			</div>
		</div>
	</div>
</section>