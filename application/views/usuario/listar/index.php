<section class="container" role="main">
	<header class="page-header">
		<h1>Lista de usuários</h1>
	</header>

	<?= Helper_Mensagens::exibir($mensagens) ?>
	<?= View::factory('usuario/listar/lista')->set('usuarios', $usuarios)->set('mensagens', $mensagens) ?>
	<?= Helper_Paginacao::exibir($paginacao) ?>

	<footer>
		<?= html::anchor('usuario/inserir', '<i class="glyphicon glyphicon-plus"></i> Adicionar Usuário', array('class' => 'btn btn-success btn-lg')) ?>
	</footer>
</section>