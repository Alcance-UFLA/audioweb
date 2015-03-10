<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1 id="titulo-principal"><i class="glyphicon glyphicon-picture"></i> Lista de Imagens</h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?php if ($imagens['paginacao']['total_registros']): ?>
	<?= View::factory('audioimagem/listar/lista')->set('imagens', $imagens) ?>
	<div class="text-center">
		<?= Helper_Paginacao::exibir($imagens['paginacao']) ?>
	</div>
	<?php else: ?>
	<p class="lead">Nenhuma imagem cadastrada.</p>
	<?php endif ?>
	<footer class="well">
		<span class="sr-only">Operações sobre imagens:</span>
		<?= HTML::anchor('audioimagem/inserir', '<i class="glyphicon glyphicon-plus"></i> Inserir Imagem', array('class' => 'btn btn-success btn-lg')) ?>
		<span class="sr-only">,</span>&nbsp;
		<a class="btn btn-default btn-lg" href="<?= Route::url('principal') ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a página inicial</span></a>
	</footer>
</section>