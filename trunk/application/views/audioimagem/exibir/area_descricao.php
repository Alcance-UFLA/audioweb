<div id="descricao-imagem" role="contentinfo">
	<h2><i class="glyphicon glyphicon-picture"></i> Dados da imagem <span class="sr-only"><?= HTML::chars($imagem['nome']) ?></span></h2>
	<dl class="dl-horizontal">
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