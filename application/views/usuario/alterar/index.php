<?php HTML::start_block() ?>
<section class="container" role="main">
	<header class="page-header">
		<?= HTML::header('Alterar usuário') ?>
	</header>
	<?= View::factory('usuario/alterar/form')->set('usuario', $usuario)->set('mensagens', $mensagens) ?>
</section>
<?php HTML::end_block() ?>