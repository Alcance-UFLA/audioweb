<section class="container" role="main">
	<header class="page-header">
		<h1>Remover usuário</h1>
	</header>
	<?= View::factory('usuario/remover/form')->set('usuario', $usuario)->set('mensagens', $mensagens) ?>
</section>