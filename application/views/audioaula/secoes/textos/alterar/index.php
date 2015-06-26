<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('<i class="glyphicon glyphicon-pencil"></i> Alterar texto da seção') ?>
		<?= HTML::start_help() ?>
			<p>
				Nesta página há um formulário para alterar os seguintes dados:
				<ol>
					<li>Texto da Seção.</li>
				</ol>
			</p>
			<p>Após preencher os dados, o usuário pode salvar os dados apertando o botão "Alterar<span class="sr-only"> texto</span>".</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('audioaula/secoes/textos/alterar/form')->set('form_texto', $form_texto)->set('secao', $secao) ?>
			</div>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>
