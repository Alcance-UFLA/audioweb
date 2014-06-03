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
<body>

<?= $content ?>

<?php foreach ($head['scripts'] as $script): ?>
<script <?= HTML::attributes($script) ?>></script>
<?php endforeach ?>

</body>
</html>