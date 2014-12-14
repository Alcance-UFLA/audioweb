<map id="mapa-regioes" name="mapa-regioes">
	<?php foreach ($imagem['regioes'] as $regiao): ?>
	<area id="area-<?= $regiao['id_imagem_regiao'] ?>" data-id-imagem-regiao="<?= $regiao['id_imagem_regiao'] ?>" shape="<?= $regiao['tipo_regiao'] ?>" coords="<?= $regiao['coordenadas'] ?>" data-coords-original="<?= $regiao['coordenadas'] ?>" rel="tag" href="#regiao-<?= $regiao['id_imagem_regiao'] ?>" alt="<?= HTML::chars($regiao['nome']) ?>" />
	<?php endforeach ?>
</map>