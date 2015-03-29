<?php HTML::start_block() ?>
<section class="container" role="main">
	<header class="page-header">
		<?= HTML::header('Remover usuário') ?>
	</header>
	<?= View::factory('usuario/remover/form')->set('usuario', $usuario)->set('mensagens', $mensagens) ?>
</section>
<?php HTML::end_block() ?>