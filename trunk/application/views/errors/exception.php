<?php if (Kohana::$environment === Kohana::DEVELOPMENT): ?>
<?php
$linhas = array_slice(file($exception->getFile(), FILE_IGNORE_NEW_LINES), max(0, $exception->getLine() - 6), 11);
?>

<div style="border: 1px solid #CCCCCC;">
	<h1 style="padding: 5px; margin: 0; background-color: #FF8080; font-size: 20px;"><?= get_class($exception) ?>#<?= $exception->getCode() ?></h1>
	<div style="padding: 10px;">
		<p><?= $exception->getMessage() ?></p>
		<hr />
		<p>Arquivo: <?= $exception->getFile() ?></p>
		<p>Linha: <?= $exception->getLine() ?></p>
		<pre style="border: 1px inset #FFFFAA; background-color: #FFFFAA; overflow: auto;"><?= implode("\n", $linhas) ?></pre>
		<p>Backtrace</p>
		<pre style="border: 1px inset #FFFFAA; background-color: #FFFFAA; overflow: auto;"><?= $exception->getTraceAsString() ?></pre>
	</div>
</div>
<?php endif ?>