<article id="teclas" class="panel panel-primary">
	<header class="panel-heading">
		<h2 class="panel-title"><i class="glyphicon glyphicon-list"></i> Teclas de atalho</h2>
	</header>
	<div class="panel-body">
		<ul id="lista-teclas">
			<?php foreach ($teclas as $nome => $tecla): ?>
			<li class="tecla" data-nome="<?= $nome ?>" data-codigo="<?= $tecla['codigo'] ?>">Tecla "<?= HTML::chars($tecla['tecla']) ?>": <?= HTML::chars($tecla['acao']) ?></li>
			<?php endforeach ?>
		</ul>
	</div>
</article>