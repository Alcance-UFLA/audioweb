<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1>Lista de Imagens</h1>
	</header>

	<ol class="breadcrumb">
		<li><a href="<?= Route::url('principal') ?>">Início</a></li>
		<li class="active">AudioImagem</li>
	</ol>

	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?php if ($imagens['paginacao']['total_registros']): ?>
	<?= View::factory('audioimagem/listar/lista')->set('imagens', $imagens) ?>
	<?= Helper_Paginacao::exibir($imagens['paginacao']) ?>
	<?php else: ?>
	<p class="lead">Nenhuma imagem cadastrada.</p>
	<?php endif ?>

	<footer>
		<?= html::anchor('audioimagem/inserir', '<i class="glyphicon glyphicon-plus"></i> Inserir Imagem', array('class' => 'btn btn-success btn-lg')) ?>
	</footer>
</section>