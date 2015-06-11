<?php
$primeiro_registro = ($imagens['paginacao']['pagina'] - 1) * $imagens['paginacao']['itens_pagina'];
?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<ul class="list-group" role="list" aria-labelledby="titulo-principal">
			<?php foreach ($imagens['lista'] as $i => $imagem): ?>
			<li class="list-group-item" role="listitem" aria-setsize="<?= number_format($imagens['paginacao']['total_registros'], 0, '.', '') ?>" aria-posinset="<?= number_format($primeiro_registro + $i + 1, 0, '.', '') ?>">
				<div class="row">
					<div class="col-md-2">
						<img src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'], 'tamanho' => '50x50')) ?>" alt="<?= HTML::chars($imagem['nome']) ?>" />
					</div>
					<div class="col-md-7">
						<a class="lead" href="<?= Route::URL('acao_id', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'])) ?>"><?= HTML::chars($imagem['nome']) ?></a>
					</div>
					<div class="col-md-3">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" id="opcoes-imagem-<?= $imagem['id_imagem'] ?>" data-toggle="dropdown" aria-expanded="false">
								Opções <span class="sr-only">da Imagem <?= HTML::chars($imagem['nome']) ?></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="opcoes-imagem-<?= $imagem['id_imagem'] ?>">
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('acao_id', array('directory' => 'audioimagem', 'controller' => 'alterar', 'id' => $imagem['id_imagem'])) ?>"><i class="glyphicon glyphicon-pencil"></i> <span>Alterar <span class="sr-only">Imagem <?= HTML::chars($imagem['nome']) ?></span></span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('acao_id', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $imagem['id_imagem'])) ?>"><i class="glyphicon glyphicon-tag"></i> <span>Mapear <span class="sr-only">Imagem <?= HTML::chars($imagem['nome']) ?></span></span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('acao_id', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'])) ?>"><i class="glyphicon glyphicon-eye-open"></i> <span>Exibir <span class="sr-only">Imagem <?= HTML::chars($imagem['nome']) ?></span></span></a>
							</ul>
						</div>
					</div>
				</div>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>