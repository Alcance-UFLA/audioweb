<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-eye-open"></i> Exibir imagem <small><?= HTML::chars($imagem['nome']) ?></small></h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<img id="imagem" class="img-responsive" usemap="#mapa-regioes" alt="<?= HTML::chars($imagem['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'])) ?>" width="<?= $imagem['largura'] ?>" height="<?= $imagem['altura'] ?>" data-largura-original="<?= $imagem['largura'] ?>" data-altura-original="<?= $imagem['altura'] ?>" />
	<div id="regioes">
		<h2><i class="glyphicon glyphicon-tags"></i> Regiões <span class="sr-only">da imagem <?= HTML::chars($imagem['nome']) ?></span></h2>
		<?php foreach ($imagem['regioes'] as $i => $regiao): ?>
		<details class="regiao">
			<summary><b>Região <?= $i + 1 ?>:</b> <span class="regiao-nome"><?= HTML::chars($regiao['nome']) ?></span></summary>
			<p class="regiao-descricao"><?= HTML::chars($regiao['descricao']) ?></p>
			<audio id="audio-<?= $regiao['id_imagem_regiao']?>-nome" preload="auto" <?= $debug ? 'controls="controls"' : '' ?> src="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'], 'opcao2' => 'audio', 'opcao3' => 'nome.mp3')) . '?' . http_build_query(array('driver' => $sintetizador['driver'], 'config' => $sintetizador['config'])) ?>"></audio>
			<audio id="audio-<?= $regiao['id_imagem_regiao']?>-descricao" preload="auto" <?= $debug ? 'controls="controls"' : '' ?> src="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'], 'opcao2' => 'audio', 'opcao3' => 'descricao.mp3')) . '?' . http_build_query(array('driver' => $sintetizador['driver'], 'config' => $sintetizador['config'])) ?>"></audio>
		</details>
		<?php endforeach ?>
	</div>
	<footer>
		<map id="mapa-regioes" name="mapa-regioes">
			<?php foreach ($imagem['regioes'] as $regiao): ?>
			<area data-id-imagem-regiao="<?= $regiao['id_imagem_regiao'] ?>" shape="<?= $regiao['tipo_regiao'] ?>" coords="<?= $regiao['coordenadas'] ?>" rel="tag" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'])) ?>" alt="<?= HTML::chars($regiao['nome']) ?>" data-descricao="<?= HTML::chars($regiao['descricao']) ?>" />
			<?php endforeach ?>
		</map>
	</footer>
</section>