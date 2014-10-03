<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-plus"></i> Inserir imagem</h1>
	</header>

	<nav>
		<span class="sr-only">Navegação:</span>
		<ol class="breadcrumb">
			<li><a href="<?= Route::url('principal') ?>">Início</a></li>
			<li><a href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>">AudioImagem</a></li>
			<li class="active">Inserir Imagem</li>
		</ol>
	</nav>

	<?= Helper_Mensagens::exibir($mensagens) ?>

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('audioimagem/inserir/form')->set('form_imagem', $form_imagem) ?>
			</div>
		</div>
	</div>
</section>