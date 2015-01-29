<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1>AudioWeb <small>Área do Usuário</small></h1>
	</header>
	<?= Helper_Trilha::exibir($trilha, array('class' => 'sr-only')) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<p class="lead">Bem vindo ao AudioWeb!</p>
	<p class="sr-only">Acesse uma das áreas do sistema:</p>
	<ul class="row list-unstyled">
		<li class="col-sm-3">
			<a class="icone-grande" href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>">
				<i class="glyphicon glyphicon-picture"></i>
				<span>AudioImagem</span>
			</a>
		</li>
		<li class="col-sm-3">
			<a class="icone-grande" href="#TODO">
				<i class="glyphicon glyphicon-formula"></i>
				<span>AudioFórmula</span>
			</a>
		</li>
		<li class="col-sm-3">
			<a class="icone-grande" href="#TODO">
				<i class="glyphicon glyphicon-education"></i>
				<span>AudioAula</span>
			</a>
		</li>
		<li class="col-sm-3">
			<a class="icone-grande" href="#TODO">
				<i class="glyphicon glyphicon-cog"></i>
				<span>Alterar preferências</span>
			</a>
		</li>
	</ul>
</section>