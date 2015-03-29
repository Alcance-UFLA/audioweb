<?php HTML::start_block() ?>
<section class="container" role="main">
	<header class="page-header">
		<?= HTML::header('Lista de usuários') ?>
	</header>

	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?= View::factory('usuario/listar/lista')->set('usuarios', $usuarios)->set('mensagens', $mensagens) ?>
	<?= Helper_Paginacao::exibir($paginacao) ?>

	<footer>
		<?= html::anchor('usuario/inserir', '<i class="glyphicon glyphicon-plus"></i> Adicionar Usuário', array('class' => 'btn btn-success btn-lg')) ?>
	</footer>
</section>
<?php HTML::end_block() ?>