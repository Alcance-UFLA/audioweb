<?php HTML::start_block() ?>
<article id="descricao-imagem" class="panel panel-primary">
	<header id="cabecalho-descricao-imagem" class="panel-heading" role="tab">
		<?= HTML::start_header(array('class' => 'panel-title')) ?>
			<a class="collapsed" data-toggle="collapse" data-parent="#lista-recursos" href="#conteudo-descricao-imagem" aria-expanded="true" aria-controls="conteudo-descricao-imagem">
				<i class="glyphicon glyphicon-picture"></i> Dados da imagem <span class="sr-only"><?= HTML::chars($imagem['nome']) ?></span>
			</a>
		<?= HTML::end_header() ?>
	</header>
	<div id="conteudo-descricao-imagem" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="cabecalho-descricao-imagem">
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
	</div>
</article>
<?php HTML::end_block() ?>