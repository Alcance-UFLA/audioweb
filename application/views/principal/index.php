<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::header('AudioWeb <small>Área do Usuário</small>') ?>
		<?= HTML::start_help() ?>
			<p>A seguir há quatro links de opções para o usuário: AudioImagem, AudioFórmula, AudioAula e Alterar Preferências. Apenas a opção AudioImagem está disponível.</p>
		<?= HTML::end_help() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha, array('class' => 'sr-only')) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<p class="lead">Bem vindo ao AudioWeb!</p>
	<p class="sr-only">Acesse uma das áreas do sistema:</p>
	<ul class="row list-unstyled">
		<li class="col-sm-3">
			<a class="icone-grande" href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>">
				<i class="glyphicon glyphicon-picture" aria-describedby="label-audioimagem"></i>
				<span id="label-audioimagem">AudioImagem</span>
			</a>
		</li>
		<li class="col-sm-3">
			<a class="icone-grande" href="#TODO">
				<i class="glyphicon glyphicon-formula" aria-describedby="label-audioformula"></i>
				<span id="label-audioformula">AudioFórmula</span>
			</a>
		</li>
		<li class="col-sm-3">
			<a class="icone-grande" href="<?= Route::url('listar', array('directory' => 'audioaula')) ?>">
				<i class="glyphicon glyphicon-education" aria-describedby="label-audioaula"></i>
				<span id="label-audioaula">AudioAula</span>
			</a>
		</li>
		<li class="col-sm-3">
			<a class="icone-grande" href="<?= Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar')) ?>">
				<i class="glyphicon glyphicon-wrench" aria-describedby="label-preferencias"></i>
				<span id="label-preferencias">Alterar preferências</span>
			</a>
		</li>
	</ul>
</section>
<?php HTML::end_block() ?>
