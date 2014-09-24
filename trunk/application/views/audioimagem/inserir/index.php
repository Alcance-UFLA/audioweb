<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1>Inserir imagem</h1>
	</header>

	<ol class="breadcrumb">
		<li><a href="<?= Route::url('principal') ?>">Início</a></li>
		<li><a href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>">AudioImagem</a></li>
		<li class="active">Inserir Imagem</li>
	</ol>

	<?= Helper_Mensagens::exibir($mensagens) ?>

	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('audioimagem/inserir/form')->set('form_imagem', $form_imagem) ?>
			</div>
		</div>
	</div>
</section>