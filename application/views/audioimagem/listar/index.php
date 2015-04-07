<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::start_header(array('id' => 'titulo-principal')) ?>
			<i class="glyphicon glyphicon-picture"></i> Lista de Imagens
		<?= HTML::end_header() ?>
		<?= HTML::start_help() ?>
			<p>Nesta página há uma lista de imagens já preparadas e audiodescritas. O usuário pode percorrê-la, através de seus links. O nome do link é o nome da imagem, ou seja, a descrição curta da imagem. Para cada uma delas, o usuário tem as opções de: Alterar, Mapear e Exibir. A opção Alterar permite o usuário alterar a imagem, sua descrição curta, descrição longa, seu tipo e público alvo. A opção Mapear permite o usuário marcar regiões dentro da imagem e audiodescrevê-as. Ao final da lista, há ainda a opção de avançar para as páginas seguintes com imagens. Por último há também a opção de adicionar uma nova imagem para audiodescrevê-la, através do botão "Inserir Imagem".</p>
		<?= HTML::end_help() ?>
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
<?php HTML::end_block() ?>
