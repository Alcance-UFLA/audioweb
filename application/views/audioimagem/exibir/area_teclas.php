<?php HTML::start_block() ?>
<article id="teclas" class="panel panel-primary">
	<header id="cabecalho-teclas" class="panel-heading" role="tab">
		<?= HTML::start_header(array('class' => 'panel-title')) ?>
			<a class="collapsed" data-toggle="collapse" data-parent="#lista-recursos" href="#conteudo-teclas" aria-expanded="false" aria-controls="conteudo-teclas">
				<i class="glyphicon glyphicon-list"></i> Teclas de atalho
			</a>
		<?= HTML::end_header() ?>
	</header>
	<div id="conteudo-teclas" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-teclas">
		<div class="panel-body">
			<ul id="lista-teclas" class="list-unstyled">
				<?php foreach ($teclas as $nome => $tecla): ?>
				<li class="tecla" data-nome="<?= $nome ?>" data-codigo="<?= $tecla['codigo'] ?>" data-alt="<?= isset($tecla['alt']) && $tecla['alt'] ? '1' : '0' ?>" data-ctrl="<?= isset($tecla['ctrl']) && $tecla['ctrl'] ? '1' : '0' ?>" data-shift="<?= isset($tecla['shift']) && $tecla['shift'] ? '1' : '0' ?>"><span class="sr-only">Tecla</span> <kbd><?= HTML::chars($tecla['tecla']) ?></kbd>: <?= HTML::chars($tecla['acao']) ?></li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</article>
<?php HTML::end_block() ?>