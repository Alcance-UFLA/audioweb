<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1>Lista de Imagens</h1>
	</header>

	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?= View::factory('audioimagem/listar/lista')->set('imagens', $imagens) ?>
	<?= Helper_Paginacao::exibir($paginacao) ?>

	<footer>
		<?= html::anchor('audioimagem/inserir', '<i class="glyphicon glyphicon-plus"></i> Adicionar Imagem', array('class' => 'btn btn-success btn-lg')) ?>
	</footer>
</section>