<article id="descricao-imagem" class="panel panel-primary">
	<header class="panel-heading">
		<h2 class="panel-title"><i class="glyphicon glyphicon-picture"></i> Dados da imagem <span class="sr-only"><?= HTML::chars($imagem['nome']) ?></span></h2>
	</header>
	<div class="panel-body">
		<dl>
			<dt>Nome:</dt>
			<dd><?= HTML::chars($imagem['nome']) ?></dd>
			<dt>Descrição:</dt>
			<dd><?= HTML::chars($imagem['descricao']) ?></dd>
			<dt>Tipo:</dt>
			<dd><?= HTML::chars($imagem['tipo_imagem']['nome']) ?></dd>
			<?php if ($imagem['rotulos']): ?>
			<dt>Rótulos:</dt>
			<?php     foreach ($imagem['rotulos'] as $rotulo): ?>
			<dd><?= HTML::chars($rotulo) ?></dd>
			<?php     endforeach ?>
			<?php endif ?>
			<?php if ($imagem['publicos_alvos']): ?>
			<dt>Públicos álvos:</dt>
			<?php     foreach ($imagem['publicos_alvos'] as $publico_alvo): ?>
			<dd><?= HTML::chars($publico_alvo['nome']) ?></dd>
			<?php     endforeach ?>
			<?php endif ?>
		</dl>
	</div>
</article>