<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('<i class="glyphicon glyphicon-plus"></i> Inserir texto na seção <small>' . HTML::chars($secao['titulo']) . '</small>') ?>
		<?= HTML::start_help() ?>
			<p>
				Nesta página há um formulário para inserir os seguintes dados:
				<ol>
					<li>Texto de uma seção.</li>
				</ol>
			</p>
			<p>Após preencher os dados, o usuário pode salvar os dados apertando o botão "Inserir<span class="sr-only"> novo texto na seção</span>".</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-8 col-lg-offset-2">
			<div class="well">
				<?= View::factory('audioaula/secoes/textos/inserir/form')->set('form_texto', $form_texto)->set('secao', $secao) ?>
			</div>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>
