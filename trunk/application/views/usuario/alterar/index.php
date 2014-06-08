<section class="container" role="main">
	<header class="page-header">
		<h1>Alterar usuário</h1>
	</header>
	<?= View::factory('usuario/alterar/form')->set('usuario', $usuario)->set('mensagens', $mensagens) ?>
</section>