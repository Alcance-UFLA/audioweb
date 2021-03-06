<aside id="conteudo-auxiliar" <?= $debug ? '' : 'class="hide"' ?> role="presentation">
	<?php if ($sintetizador['driver']): ?>
	<?php foreach ($audio_auxiliar as $id_audio_auxiliar => $audio_auxiliar): ?>
	<audio id="<?= $id_audio_auxiliar ?>" class="<?= $audio_auxiliar['class'] ?>" src="<?= HTML::chars($audio_auxiliar['url']) ?>" preload="auto" <?= isset($audio_auxiliar['loop']) ? 'loop="loop"' : '' ?> <?= $debug ? 'controls="controls"' : '' ?>></audio>
	<?php endforeach ?>
	<?php endif ?>
</aside>

<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::start_header() ?>
			<i class="glyphicon glyphicon-eye-open"></i> Exibir imagem <small><?= HTML::chars($imagem['nome']) ?></small>
		<?= HTML::end_header() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<div class="row">
		<div id="coluna-imagem" class="col-md-8">
			<img id="imagem" usemap="#mapa-regioes" alt="<?= HTML::chars($imagem['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'])) ?>" width="<?= $imagem['largura'] ?>" height="<?= $imagem['altura'] ?>" data-largura-original="<?= $imagem['largura'] ?>" data-altura-original="<?= $imagem['altura'] ?>" data-sintetizador="<?= $sintetizador['driver'] ?>" data-modo-exibicao="<?= $modo_exibicao ?>" />
		</div>
		<div id="coluna-opcoes-imagem" class="col-md-4">
			<div class="panel-group" id="lista-recursos" role="tablist" aria-multiselectable="true">
				<?= View::factory('audioimagem/exibir/area_descricao')->set('imagem', $imagem)->set('sintetizador', $sintetizador) ?>
				<?= View::factory('audioimagem/exibir/area_regioes')->set('imagem', $imagem)->set('sintetizador', $sintetizador) ?>
				<?= View::factory('audioimagem/exibir/area_teclas')->set('teclas', $teclas) ?>
			</div>
		</div>
	</div>
	<footer id="rodape-imagem">
		<?= View::factory('audioimagem/exibir/mapa_regioes')->set('imagem', $imagem) ?>
		<div id="area-botoes" class="well hidden-print">
			<?php if ($id_aula): ?>
			<a class="btn btn-lg btn-default" href="<?= Route::url('acao_id', array('directory' => 'audioaula', 'controller' => 'exibir', 'id' => $id_aula)) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a aula</span></a>
			<?php else: ?>
			<a class="btn btn-lg btn-default" href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para lista de imagens</span></a>
			<?php endif ?>
			<span class="sr-only">,</span>
			<a class="btn btn-lg btn-default" href="<?= Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $imagem['id_imagem']))?>"><i class="glyphicon glyphicon-tag"></i> Mapear imagem</a>
		</div>
	</footer>
</section>
<?php HTML::end_block() ?>