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
<body class="respiro-navbar" data-url-base="<?= URL::site() ?>" data-versao="<?= Kohana::$config->load('audioweb.versao') ?>" itemscope="itemscope" itemtype="http://schema.org/<?= $pagina['tipo'] ?>">

<a href="#conteudo-principal" class="sr-only sr-only-focusable" accesskey="2">Ir para o conteúdo principal</a>

<div id="navbar-pagina" class="navbar navbar-inverse navbar-fixed-top hidden-print" role="banner" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
	<div class="container">

		<div class="navbar-header">
			<button id="btn-navegacao" class="navbar-toggle" type="button" data-toggle="collapse" data-target=".audioweb-navbar-collapse" aria-haspopup="true">
				<span class="sr-only">Navegação</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div>
				<?php if ($usuario_logado): ?>
				<a class="navbar-brand" accesskey="1" href="<?= Route::url('principal') ?>"><span class="sr-only">Página inicial do</span> AudioWeb</a>
				<?php else: ?>
				<a class="navbar-brand" accesskey="1" href="<?= Route::url('default') ?>"><span class="sr-only">Apresentação do</span> AudioWeb</a>
				<?php endif ?>
			</div>
		</div>

		<nav class="audioweb-navbar-collapse collapse navbar-collapse" role="navigation">
			<ul class="nav navbar-nav navbar-left" role="menubar">
				<?php if ( ! $usuario_logado): ?>
				<li role="menuitem"><a href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'audioweb')) ?>"><i class="glyphicon glyphicon-info-sign"></i> Sobre <span class="sr-only">o AudioWeb</span></a></li>
				<li role="menuitem"><a href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'institucional')) ?>"><i class="glyphicon glyphicon-globe"></i> Institucional</a></li>
				<?php endif ?>
				<?php if (isset($url_funcionamento)): ?>
				<li role="menuitem"><a accesskey="0" href="<?= $url_funcionamento ?>"><i class="glyphicon glyphicon-cog"></i> Funcionamento desta página</a></li>
				<?php else: ?>
				<li role="menuitem"><a accesskey="0" href="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'funcionamento')) ?>"><i class="glyphicon glyphicon-cog"></i> Funcionamento <span class="sr-only">do AudioWeb</span></a></li>
				<?php endif ?>
			</ul>
			<ul class="nav navbar-nav navbar-right" role="menubar">
				<?php if ($usuario_logado): ?>
				<li role="menuitem"><span class="navbar-text"><i class="glyphicon glyphicon-user"></i> <span class="sr-only">Logado como</span> <?= HTML::chars($usuario_logado['email']) ?></span></li>
				<li role="menuitem"><?= HTML::anchor('autenticacao/sair', '<i class="glyphicon glyphicon-off"></i> Sair <span class="sr-only">do sistema</span>') ?></li>
				<?php else: ?>
				<li role="menuitem"><?= HTML::anchor('autenticacao/autenticar', '<i class="glyphicon glyphicon-log-in"></i> Entrar <span class="sr-only">no sistema</span>') ?></li>
				<li role="menuitem"><?= HTML::anchor('usuario/cadastrar', '<i class="glyphicon glyphicon-plus"></i> Cadastre-se') ?></li>
				<?php endif ?>
			</ul>
		</nav>
	</div>
</div>

<?= $content ?>

<div class="container">
	<div id="rodape-pagina" class="text-muted hidden-print" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
		<p><span class="sr-only">Copyright</span> &copy; <time itemprop="copyrightYear" datetime="<?= strftime('%Y', $request_time) ?>"><?= strftime('%Y', $request_time) ?></time> <span itemprop="copyrightHolder" itemscope="itemscope" itemtype="http://schema.org/Organization"><span itemprop="name">AudioWeb</span></span><span class="sr-only">.</span> <span class="pull-right">Conheça nossa <a rel="nofollow" href="<?= Route::url('politica_de_privacidade') ?>">Política de Privacidade</a><span class="sr-only">.</span></span></p>
	</div>
</div>

<?php foreach ($head['scripts'] as $script): ?>
<script <?= HTML::attributes($script) ?>></script>
<?php endforeach ?>

<?php foreach ($pagina['meta'] as $itemprop => $itemvalue): ?>
<?php     if (is_array($itemvalue)): ?>
<?php         foreach ($itemvalue as $value): ?>
<meta itemprop="<?= HTML::chars($itemprop) ?>" content="<?= HTML::chars($value) ?>" />
<?php         endforeach ?>
<?php     else: ?>
<meta itemprop="<?= HTML::chars($itemprop) ?>" content="<?= HTML::chars($itemvalue) ?>" />
<?php     endif ?>
<?php endforeach?>

</body>
</html>