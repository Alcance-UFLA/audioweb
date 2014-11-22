<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-eye-open"></i> Exibir imagem <small><?= HTML::chars($imagem['nome']) ?></small></h1>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div id="coluna-imagem" class="col-md-8">
			<img id="imagem" usemap="#mapa-regioes" alt="<?= HTML::chars($imagem['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'])) ?>" width="<?= $imagem['largura'] ?>" height="<?= $imagem['altura'] ?>" data-largura-original="<?= $imagem['largura'] ?>" data-altura-original="<?= $imagem['altura'] ?>" data-sintetizador="<?= $sintetizador['driver'] ?>" data-modo-exibicao="<?= $modo_exibicao ?>" />
		</div>
		<div id="coluna-opcoes-imagem" class="col-md-4">
			<?= View::factory('audioimagem/exibir/area_descricao')->set('imagem', $imagem)->set('sintetizador', $sintetizador) ?>
			<?= View::factory('audioimagem/exibir/area_regioes')->set('imagem', $imagem)->set('sintetizador', $sintetizador) ?>
			<?= View::factory('audioimagem/exibir/area_teclas')->set('teclas', $teclas) ?>
		</div>
	</div>
	<footer id="rodape-imagem">
		<?= View::factory('audioimagem/exibir/mapa_regioes')->set('imagem', $imagem) ?>
		<div id="area-botoes" class="well hidden-print">
			<a class="btn btn-lg btn-default" href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para lista de imagens</span></a>
			<span class="sr-only">,</span>
			<a class="btn btn-lg btn-default" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'action' => 'index', 'id' => $imagem['id_imagem']))?>"><i class="glyphicon glyphicon-tag"></i> Mapear imagem</a>
		</div>
	</footer>
</section>
<aside id="conteudo-auxiliar" class="hide" role="presentation">
	<?php if ($sintetizador['driver']): ?>
	<audio id="audio-bip" src="<?= URL::site('som/bip.mp3') ?>" <?= $debug ? 'controls="controls"' : '' ?> preload="auto" loop="loop"></audio>
	<?php endif ?>
</aside>