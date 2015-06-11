<?php HTML::start_block() ?>
<article id="regioes" class="panel panel-primary">
	<header id="cabecalho-regioes" class="panel-heading" role="tab">
		<?= HTML::start_header(array('class' => 'panel-title')) ?>
			<a class="collapsed" data-toggle="collapse" data-parent="#lista-recursos" href="#conteudo-regioes" aria-expanded="false" aria-controls="conteudo-regioes">
				<i class="glyphicon glyphicon-tags"></i> Regiões <span class="sr-only">da imagem <?= HTML::chars($imagem['nome']) ?></span>
			</a>
		<?= HTML::end_header() ?>
	</header>
	<div id="conteudo-regioes" class="panel-collapse collapse" role="tabpanel" aria-labelledby="cabecalho-regioes">
		<div class="panel-body">
			<?php foreach ($imagem['regioes'] as $i => $regiao): ?>
			<details id="regiao-<?= $regiao['id_imagem_regiao'] ?>" class="regiao">
				<summary><b>Região <?= $i + 1 ?>:</b> <span class="regiao-nome"><?= HTML::chars($regiao['nome']) ?></span></summary>
				<p class="regiao-descricao"><i>Descrição:</i> <?= HTML::chars($regiao['descricao']) ?></p>
				<p class="regiao-formato sr-only"><i>Formato:</i> <?= HTML::chars($regiao['caracteristicas']['formato']) ?></p>
				<p class="regiao-formato sr-only"><i>Posição:</i> <?= HTML::chars($regiao['caracteristicas']['posicao']) ?></p>
				<p class="regiao-formato sr-only"><i>Tamanho:</i> <?= HTML::chars($regiao['caracteristicas']['tamanho']) ?></p>
				<?php if ($sintetizador['driver']): ?>
				<audio id="audio-<?= $regiao['id_imagem_regiao']?>-nome" class="audio-nome" aria-labelledby="regiao-<?= $regiao['id_imagem_regiao']?>-nome" preload="auto"  src="<?= Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'], 'opcao2' => 'audio', 'opcao3' => 'nome.mp3')) . '?' . http_build_query(array('driver' => $sintetizador['driver'], 'config' => $sintetizador['config'], 'md5' => md5($regiao['nome'])), null, '&amp;') ?>" mediagroup="audiodescricao"></audio>
				<audio id="audio-<?= $regiao['id_imagem_regiao']?>-descricao" class="audio-descricao" aria-labelledby="regiao-<?= $regiao['id_imagem_regiao'] ?>-descricao" preload="auto" src="<?= Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'], 'opcao2' => 'audio', 'opcao3' => 'descricao.mp3')) . '?' . http_build_query(array('driver' => $sintetizador['driver'], 'config' => $sintetizador['config'], 'md5' => md5($regiao['descricao'])), null, '&amp;') ?>" mediagroup="audiodescricao"></audio>
				<?php endif ?>
			</details>
			<?php endforeach ?>
		</div>
	</div>
</article>
<?php HTML::end_block() ?>
