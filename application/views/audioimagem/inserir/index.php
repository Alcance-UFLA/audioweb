<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('<i class="glyphicon glyphicon-plus"></i> Inserir imagem') ?>
		<?= HTML::start_help() ?>
			<p>
				Nesta página há um formulário para inserir os seguintes dados:
				<ol>
					<li>seleção do arquivo de uma imagem;</li>
					<li>descrição curta da imagem, ou seja, o seu nome;</li>
					<li>descrição longa da imagem;</li>
					<li>o tipo da imagem, que pode ser foto, desenho, diagrama, gráfico;</li>
					<li>seus rótulos;</li>
					<li>o seu público alvo, que pode ser crianças, jovens, adultos, ensino fundamental, médio ou superior.</li>
				</ol>
			</p>
			<p>Após preencher os dados, o usuário pode salvar os dados apertando o botão "Inserir<span class="sr-only"> nova imagem</span>".</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('audioimagem/inserir/form')->set('form_imagem', $form_imagem) ?>
			</div>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>
