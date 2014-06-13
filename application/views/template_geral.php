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

<!--barra principal-->
<!--TODO: definir se os itens do menu vão ser criados e passados pelo controler 
nao mostrar menus quado o usuario nao esta logado-->
<div class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= Kohana::$base_url ?>">Audio Imagem</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
            <li><a href="TODO">Nome_Usuário</a></li>
            <li class="active"><a href="TODO">Configurações</a></li>
            <li><a href="TODO">Sair</a></li>
            </ul>
        </div>
    </div>
</div>

<?= $content ?>

<?php foreach ($head['scripts'] as $script): ?>
<script <?= HTML::attributes($script) ?>></script>
<?php endforeach ?>

</body>
</html>