<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= I18n::$lang ?>" lang="<?= I18n::$lang ?>" dir="ltr">
<head>
<meta charset="<?= Kohana::$charset ?>" />
<title><?= HTML::chars($head['title']) ?></title>

<?php foreach ($head['links'] as $link): ?>
<link <?= HTML::attributes($link) ?> />
<?php endforeach ?>

<?php foreach ($head['metas'] as $meta): ?>
<meta <?= HTML::attributes($meta) ?> />
<?php endforeach ?>

<!--[if lt IE 9]>
<script src="<?= URL::site('js/html5shiv.min.js') ?>"></script>
<script src="<?= URL::site('js/respond.min.js') ?>"></script>
<![endif]-->

</head>
<body data-url-base="<?= URL::site() ?>" class="respiro-navbar" data-versao="<?= Kohana::$config->load('audioweb.versao') ?>">

<a href="#conteudo-principal" class="sr-only">Ir para o conteúdo principal</a>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">

		<div class="navbar-header">
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".audioweb-navbar-collapse">
				<span class="sr-only">Navegação</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php if ($usuario_logado): ?>
			<a class="navbar-brand" href="<?= Route::url('principal') ?>"><span class="sr-only">Página inicial do</span> AudioWeb</a>
			<?php else: ?>
			<a class="navbar-brand" href="<?= Route::url('default') ?>"><span class="sr-only">Apresentação do</span> AudioWeb</a>
			<?php endif ?>
		</div>

		<nav class="audioweb-navbar-collapse collapse navbar-collapse" role="navigation">
			<ul class="nav navbar-nav navbar-right">
				<?php if ($usuario_logado): ?>
				<li><span class="navbar-text"><i class="glyphicon glyphicon-user"></i> <span class="sr-only">Logado como</span> <?= HTML::chars($usuario_logado['email']) ?></span></li>
				<li><?= HTML::anchor('autenticacao/sair', '<i class="glyphicon glyphicon-off"></i> Sair <span class="sr-only">do sistema</span>') ?></li>
				<?php else: ?>
				<li><?= HTML::anchor('autenticacao/autenticar', '<i class="glyphicon glyphicon-log-in"></i> Entrar <span class="sr-only">no sistema</span>') ?></li>
				<li><?= HTML::anchor('usuario/cadastrar', '<i class="glyphicon glyphicon-plus"></i> Cadastre-se') ?></li>
				<?php endif ?>
			</ul>
		</nav>
	</div>
</div>

<?= $content ?>

<hr />
<footer class="container text-muted" role="content info">
	<p><span class="sr-only">Copyright</span> &copy; <time datetime="<?= strftime('%Y', $request_time) ?>"><?= strftime('%Y', $request_time) ?></time> AudioWeb<span class="sr-only">.</span> <span class="pull-right">Conheça nossa <a target="_blank" rel="nofollow" href="<?= Route::url('politica_de_privacidade') ?>">Política de Privacidade</a><span class="sr-only">.</span></span></p>
</footer>

<?php foreach ($head['scripts'] as $script): ?>
<script <?= HTML::attributes($script) ?>></script>
<?php endforeach ?>

</body>
</html>