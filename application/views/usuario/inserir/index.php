<section class="container" role="main">
	<header class="page-header">
		<h1>Adicionar usuário</h1>
	</header>
	<?= View::factory('usuario/inserir/form')->set('usuario', $usuario)->set('mensagens', $mensagens) ?>
</section>