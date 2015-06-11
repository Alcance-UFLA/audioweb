<?php HTML::start_block() ?>
<section class="container" role="main">
	<header class="page-header">
		<?= HTML::header('Lista de usuários') ?>
	</header>

	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?= View::factory('usuario/listar/lista')->set('usuarios', $usuarios)->set('mensagens', $mensagens) ?>
	<?= Helper_Paginacao::exibir($paginacao) ?>

	<footer>
		<a class="btn btn-success btn-lg" href="<?= Route::url('acao_padrao', array('directory' => 'usuario', 'controller' => 'inserir')) ?>"><i class="glyphicon glyphicon-plus"></i> Adicionar Usuário</a>
	</footer>
</section>
<?php HTML::end_block() ?>