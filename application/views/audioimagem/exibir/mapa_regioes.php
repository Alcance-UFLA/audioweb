<map id="mapa-regioes" name="mapa-regioes">
	<?php foreach ($imagem['regioes'] as $regiao): ?>
	<area data-id-imagem-regiao="<?= $regiao['id_imagem_regiao'] ?>" shape="<?= $regiao['tipo_regiao'] ?>" coords="<?= $regiao['coordenadas'] ?>" rel="tag" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'], 'action' => 'regiao', 'opcao1' => $regiao['id_imagem_regiao'])) ?>" alt="<?= HTML::chars($regiao['nome']) ?>" data-descricao="<?= HTML::chars($regiao['descricao']) ?>" />
	<?php endforeach ?>
</map>