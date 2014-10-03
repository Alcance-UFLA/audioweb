<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-tag"></i> Mapear imagem</h1>
	</header>

	<nav>
		<span class="sr-only">Navegação:</span>
		<ol class="breadcrumb">
			<li><a href="<?= Route::url('principal') ?>">Início</a></li>
			<li><a href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>">AudioImagem</a></li>
			<li class="active">Mapear Imagem</li>
		</ol>
	</nav>

	<?= Helper_Mensagens::exibir($mensagens) ?>

	<div class="row">
		<div class="col-md-4">
			<?= View::factory('audioimagem/mapear/lista_regioes')->set('form_imagem', $form_imagem) ?>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<img class="img-responsive" alt="<?= HTML::chars($form_imagem['dados']['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $form_imagem['dados']['id_conta'], 'nome' => $form_imagem['dados']['arquivo'])) ?>" />
			</div>
		</div>
	</div>
</section>