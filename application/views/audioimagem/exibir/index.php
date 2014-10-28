<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-eye-open"></i> Exibir imagem <small><?= HTML::chars($imagem['nome']) ?></small></h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<article id="imagem-mapeada">
		<header class="sr-only">
			<h2><?= HTML::chars($imagem['nome']) ?></h2>
		</header>
		<img id="imagem" class="img-responsive" usemap="#mapa" alt="<?= HTML::chars($imagem['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'])) ?>" width="<?= $imagem['largura'] ?>" height="<?= $imagem['altura'] ?>" data-largura-original="<?= $imagem['largura'] ?>" data-altura-original="<?= $imagem['altura'] ?>" />
		<footer>
			<map id="mapa">
				<?php foreach ($imagem['regioes'] as $regiao): ?>
				<area data-id-imagem-regiao="<?= $regiao['id_imagem_regiao'] ?>" shape="<?= $regiao['tipo_regiao'] ?>" coords="<?= $regiao['coordenadas'] ?>" rel="tag" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'])) ?>" alt="<?= HTML::chars($regiao['nome']) ?>" data-descricao="<?= HTML::chars($regiao['descricao']) ?>" />
				<?php endforeach ?>
			</map>
			<div id="audios">
				<?php foreach ($imagem['regioes'] as $i => $regiao): ?>
				<div class="audio">
					<details>
						<summary><b>Região <?= $i + 1 ?>:</b> <span class="regiao-nome"><?= HTML::chars($regiao['nome']) ?></span></summary>
						<p class="regiao-descricao"><?= HTML::chars($regiao['descricao']) ?></p>
					</details>
					<audio id="audio-<?= $regiao['id_imagem_regiao']?>-nome" preload="auto" <?= $debug ? 'controls="controls"' : '' ?> src="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'], 'opcao2' => 'audio', 'opcao3' => 'nome')) ?>"></audio>
					<audio id="audio-<?= $regiao['id_imagem_regiao']?>-descricao" preload="auto" <?= $debug ? 'controls="controls"' : '' ?> src="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'], 'opcao2' => 'audio', 'opcao3' => 'descricao')) ?>"></audio>
				</div>
				<?php endforeach ?>
			</div>
		</footer>
	</article>
</section>