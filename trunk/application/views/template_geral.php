<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= I18n::$lang ?>" lang="<?= I18n::$lang ?>" dir="ltr">
<head>
<meta charset="<?= Kohana::$charset ?>" />
<title><?= HTML::entities($head['title']) ?></title>

<?php foreach ($head['links'] as $link): ?>
<link <?= HTML::attributes($link) ?> />
<?php endforeach ?>

<?php foreach ($head['metas'] as $meta): ?>
<meta <?= HTML::attributes($meta) ?> />
<?php endforeach ?>
</head>
<body data-url-base="<?= URL::site() ?>">

<div class="navbar navbar-inverse navbar-static-top" role="navigation">
	<div class="container">

		<div class="navbar-header">
			<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".audioimagem-navbar-collapse">
				<span class="sr-only">Navegação</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?= Kohana::$base_url ?>">Audio Imagem</a>
		</div>

		<nav class="audioimagem-navbar-collapse collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<?php if (Auth::instance()->logged_in()): ?>
				<li><?= HTML::anchor('', Auth::instance()->get_user()->email) ?></li>
				<li><?= HTML::anchor('autenticacao/sair', '<i class="glyphicon glyphicon-off"></i> Sair') ?></li>
				<?php else: ?>
				<li><?= HTML::anchor('autenticacao/autenticar', '<i class="glyphicon glyphicon-log-in"></i> Login') ?></li>
				<?php endif ?>
			</ul>
		</nav>
	</div>
</div>

<?= $content ?>

<?php foreach ($head['scripts'] as $script): ?>
<script <?= HTML::attributes($script) ?>></script>
<?php endforeach ?>

</body>
</html>