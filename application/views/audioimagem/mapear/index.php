<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-tag"></i> Mapear imagem <small><?= HTML::chars($form_imagem['dados']['imagem']['nome']) ?></small></h1>
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
				<img id="imagem" class="img-responsive" alt="<?= HTML::chars($form_imagem['dados']['imagem']['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $form_imagem['dados']['imagem']['id_conta'], 'nome' => $form_imagem['dados']['imagem']['arquivo'])) ?>" width="<?= $form_imagem['dados']['imagem']['largura'] ?>" height="<?= $form_imagem['dados']['imagem']['altura'] ?>" data-largura-original="<?= $form_imagem['dados']['imagem']['largura'] ?>" data-altura-original="<?= $form_imagem['dados']['imagem']['altura'] ?>" />
			</div>
			<?= View::factory('audioimagem/mapear/area_acoes')->set('form_imagem', $form_imagem) ?>
			<?= View::factory('audioimagem/mapear/form_regiao')->set('form_imagem', $form_imagem)->set('mensagens', $mensagens) ?>
			<?php if ($form_imagem['dados']['acao'] == 'remover'): ?>
			<?= View::factory('audioimagem/mapear/form_remover')->set('form_imagem', $form_imagem)->set('mensagens', $mensagens) ?>
			<?php endif ?>
		</div>
	</div>
</section>