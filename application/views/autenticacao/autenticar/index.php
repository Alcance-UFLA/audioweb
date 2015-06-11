<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('<i class="glyphicon glyphicon-log-in"></i> Acessar o AudioWeb') ?>
		<?= HTML::start_help() ?>
			<p>Para se logar, digite nos campos a seguir o seu e-mail e sua senha, e depois aperte o botão "Entrar". Caso tenha esquecido a sua senha, tecle em "Esqueceu a senha?". E caso ainda não tenha se cadastrado no AudioWeb, tecle em "Cadastre-se gratuitamente".</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3">
			<div class="well">
				<?= View::factory('autenticacao/autenticar/form')->set('form_autenticacao', $form_autenticacao) ?>
			</div>
		</div>
	</div>
	<p class="text-center">
		<b><a href="<?= Route::url('acao_padrao', array('directory' => 'usuario', 'controller' => 'cadastrar')) ?>"><i class="glyphicon glyphicon-plus"></i> Cadastre-se gratuitamente</a></b>
	</p>
</section>
<?php HTML::end_block() ?>
