<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1>AudioWeb <small>Área do Usuário</small></h1>
	</header>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<p class="lead">Bem vindo ao AudioWeb!</p>
	<div class="row">
		<div class="col-sm-3">
			<a class="icone-grande" href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>">
				<i class="glyphicon glyphicon-picture"></i>
				<span>AudioImagem</span>
			</a>
		</div>
		<div class="col-sm-3">
			<a class="icone-grande" href="#TODO">
				<i class="glyphicon">&radic;</i>
				<span>AudioFórmula</span>
			</a>
		</div>
		<div class="col-sm-3">
			<a class="icone-grande" href="#TODO">
				<i class="glyphicon glyphicon-book"></i>
				<span>AudioAula</span>
			</a>
		</div>
		<div class="col-sm-3">
			<a class="icone-grande" href="#TODO">
				<i class="glyphicon glyphicon-cog"></i>
				<span>Alterar preferências</span>
			</a>
		</div>
	</div>
</section>