<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Página inválida</title>
		<style>body { font-family: Arial, verdana, sans-serif; }</style>
	</head>
	<body>
		<h1>Página inválida</h1>
		<p><?= $message ?></p>
		<?php if (isset($exception)): ?>
		<?= View::factory('errors/exception', array('exception' => $exception)) ?>
		<?php endif ?>
	</body>
</html>