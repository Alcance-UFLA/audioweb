<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('<i class="glyphicon glyphicon-plus"></i> Cadastrar usuário') ?>
		<?= HTML::start_help() ?>
			<p>Para se cadastrar, preencha abaixo os campos nome, e­mail e senha, e depois ouça com atenção a licença gratuita de uso do AudioWeb e a sua política de privacidade. Caso concorde, assinale a opção de concordância e, por fim, clique no botão "Cadastrar<span class="sr-only"> Usuário</span>".</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="well">
				<?= View::factory('usuario/cadastrar/form')->set('form_usuario', $form_usuario) ?>
			</div>
		</div>
	</div>
</section>
<?php HTML::end_block() ?>
