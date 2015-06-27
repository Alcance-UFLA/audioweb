<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::start_header() ?>
			<i class="glyphicon glyphicon-wrench"></i> Alterar Preferências
		<?= HTML::end_header() ?>
		<?= HTML::start_help() ?>
			<p>
				Nesta página há um formulário para alterar as preferências do usuário.
			</p>
			<p>Após preencher os dados, o usuário pode salvar os dados apertando o botão "Alterar<span class="sr-only"> preferências</span>".</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<?= View::factory('preferencias/alterar/form')->set('form_preferencias', $form_preferencias) ?>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>
