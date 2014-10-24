<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-picture"></i> Lista de Imagens</h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?php if ($imagens['paginacao']['total_registros']): ?>
	<?= View::factory('audioimagem/listar/lista')->set('imagens', $imagens) ?>
	<?= Helper_Paginacao::exibir($imagens['paginacao']) ?>
	<?php else: ?>
	<p class="lead">Nenhuma imagem cadastrada.</p>
	<?php endif ?>

	<footer>
		<?= HTML::anchor('audioimagem/inserir', '<i class="glyphicon glyphicon-plus"></i> Inserir Imagem', array('class' => 'btn btn-success btn-lg')) ?>
		&nbsp;
		<?= HTML::anchor('principal', 'Voltar', array('class' => 'btn btn-default btn-lg')) ?>
	</footer>
</section>