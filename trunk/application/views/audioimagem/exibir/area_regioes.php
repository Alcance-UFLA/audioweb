<div id="regioes">
	<h2><i class="glyphicon glyphicon-tags"></i> Regiões <span class="sr-only">da imagem <?= HTML::chars($imagem['nome']) ?></span></h2>
	<?php foreach ($imagem['regioes'] as $i => $regiao): ?>
	<details id="regiao-<?= $regiao['id_imagem_regiao'] ?>" class="regiao">
		<summary><b>Região <?= $i + 1 ?>:</b> <span id="regiao-<?= $regiao['id_imagem_regiao']?>-nome" class="regiao-nome"><?= HTML::chars($regiao['nome']) ?></span></summary>
		<p id="regiao-<?= $regiao['id_imagem_regiao'] ?>-descricao" class="regiao-descricao"><?= HTML::chars($regiao['descricao']) ?></p>
		<audio id="audio-<?= $regiao['id_imagem_regiao']?>-nome" class="audio-nome" aria-labelledby="regiao-<?= $regiao['id_imagem_regiao']?>-nome" preload="auto" <?= $debug ? 'controls="controls"' : '' ?> src="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'], 'opcao2' => 'audio', 'opcao3' => 'nome.mp3')) . '?' . http_build_query(array('driver' => $sintetizador['driver'], 'config' => $sintetizador['config'])) ?>"></audio>
		<audio id="audio-<?= $regiao['id_imagem_regiao']?>-descricao" class="audio-descricao" aria-labelledby="regiao-<?= $regiao['id_imagem_regiao'] ?>-descricao" preload="auto" <?= $debug ? 'controls="controls"' : '' ?> src="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'], 'opcao2' => 'audio', 'opcao3' => 'descricao.mp3')) . '?' . http_build_query(array('driver' => $sintetizador['driver'], 'config' => $sintetizador['config'])) ?>"></audio>
	</details>
	<?php endforeach ?>
</div>