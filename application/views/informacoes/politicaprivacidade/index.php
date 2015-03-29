<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('Política de Privacidade') ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div class="col-lg-12">
			<?= View::factory('partials/politica_privacidade') ?>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>