<map id="mapa-regioes" name="mapa-regioes">
	<?php foreach ($imagem['regioes'] as $regiao): ?>
	<area id="area-<?= $regiao['id_imagem_regiao'] ?>" class="area-imagem" data-id-imagem-regiao="<?= $regiao['id_imagem_regiao'] ?>" shape="<?= $regiao['tipo_regiao'] ?>" coords="<?= $regiao['coordenadas'] ?>" data-coords-original="<?= $regiao['coordenadas'] ?>" rel="tag" href="#regiao-<?= $regiao['id_imagem_regiao'] ?>" alt="<?= HTML::chars($regiao['nome']) ?>" />
	<?php endforeach ?>
	<area id="area-borda-imagem" shape="poly" coords="<?= $imagem['coordenadas_borda'] ?>" data-coords-original="<?= $imagem['coordenadas_borda'] ?>" href="#imagem" alt="Borda da imagem" />
</map>