<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-eye-open"></i> Exibir imagem <small><?= HTML::chars($imagem['nome']) ?></small></h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<img id="imagem" class="img-responsive" usemap="#mapa-regioes" alt="<?= HTML::chars($imagem['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'])) ?>" width="<?= $imagem['largura'] ?>" height="<?= $imagem['altura'] ?>" data-largura-original="<?= $imagem['largura'] ?>" data-altura-original="<?= $imagem['altura'] ?>" />
	<?= View::factory('audioimagem/exibir/area_descricao')->set('imagem', $imagem)->set('sintetizador', $sintetizador) ?>
	<?= View::factory('audioimagem/exibir/area_regioes')->set('imagem', $imagem)->set('sintetizador', $sintetizador) ?>
	<footer>
		<?= View::factory('audioimagem/exibir/mapa_regioes')->set('imagem', $imagem) ?>
	</footer>
</section>
<aside class="container" role="presentation">
	<audio src="<?= URL::site('som/bip.mp3') ?>" <?= $debug ? 'controls="controls"' : '' ?> preload="auto" id="audio-bip"></audio>
</aside>