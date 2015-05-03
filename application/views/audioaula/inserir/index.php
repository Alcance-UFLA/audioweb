<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('<i class="glyphicon glyphicon-plus"></i> Inserir aula') ?>
		<?= HTML::start_help() ?>
			<p>
				Nesta página há um formulário para inserir os seguintes dados:
				<ol>
					<li>nome da aula;</li>
					<li>descrição da aula;</li>
					<li>seus rótulos.</li>
				</ol>
			</p>
			<p>Após preencher os dados, o usuário pode salvar os dados apertando o botão "Inserir<span class="sr-only"> nova aula</span>".</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('audioaula/inserir/form')->set('form_aula', $form_aula) ?>
			</div>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>
