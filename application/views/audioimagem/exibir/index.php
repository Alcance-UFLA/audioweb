<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-eye-open"></i> Exibir imagem <small><?= HTML::chars($imagem['nome']) ?></small></h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div class="col-md-8">
			<img id="imagem" class="img-responsive" usemap="#mapa-regioes" alt="<?= HTML::chars($imagem['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'])) ?>" width="<?= $imagem['largura'] ?>" height="<?= $imagem['altura'] ?>" data-largura-original="<?= $imagem['largura'] ?>" data-altura-original="<?= $imagem['altura'] ?>" data-sintetizador="<?= $sintetizador['driver'] ?>" />
		</div>
		<div class="col-md-4">
			<?= View::factory('audioimagem/exibir/area_descricao')->set('imagem', $imagem)->set('sintetizador', $sintetizador) ?>
			<?= View::factory('audioimagem/exibir/area_regioes')->set('imagem', $imagem)->set('sintetizador', $sintetizador) ?>
		</div>
	</div>
	<footer>
		<?= View::factory('audioimagem/exibir/mapa_regioes')->set('imagem', $imagem) ?>
	</footer>
</section>
<aside id="conteudo-auxiliar" class="hide" role="presentation">
	<?php if ($sintetizador['driver']): ?>
	<audio id="audio-bip" src="<?= URL::site('som/bip.mp3') ?>" <?= $debug ? 'controls="controls"' : '' ?> preload="auto" loop="loop"></audio>
	<?php endif ?>
</aside>