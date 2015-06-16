<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<ul id="lista-secoes" class="list-group ui-sortable" role="list" aria-labelledby="titulo-principal" data-action-salvar-posicoes="<?= Route::url('listar_secoes', array('id_aula' => $aula['id_aula'], 'action' => 'salvarposicoes')) ?>">
			<?php foreach ($secoes['lista'] as $i => $secao): ?>
			<li id="secao<?= $secao['id_secao'] ?>" class="secao list-group-item" role="listitem" data-id-secao="<?= $secao['id_secao'] ?>" data-posicao="<?= $secao['posicao'] ?>">
				<div id="titulo-secao<?= $secao['id_secao'] ?>" class="row">
					<div class="col-md-9">
						<div class="ui-sortable-handle nome-secao">
							<?php if ($secao['itens']): ?>
							<a class="lead" data-toggle="collapse" href="#itens-secao-<?= $secao['id_secao'] ?>" aria-expanded="false" aria-controls="itens-secao-<?= $secao['id_secao'] ?>">
								<span class="numero"><?= HTML::chars($secao['numero']) ?></span>
								<span class="titulo"><?= HTML::chars($secao['titulo']) ?></span>
							</a>
							<small class="badge"><span class="hide">(</span><?= count($secao['itens']) . ' ' . (count($secao['itens']) == 1 ? 'item' : 'itens') ?><span class="hide">)</span></small>
							<?php else: ?>
							<span class="lead">
								<span class="numero"><?= HTML::chars($secao['numero']) ?></span>
								<span class="titulo"><?= HTML::chars($secao['titulo']) ?></span>
							</span>
							<?php endif ?>
						</div>
					</div>
					<div class="col-md-3">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" id="opcoes-secao-<?= $secao['id_secao'] ?>" data-toggle="dropdown" aria-expanded="false">
								Opções <span class="sr-only">da Seção <?= HTML::chars($secao['titulo']) ?></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="opcoes-secao-<?= $secao['id_secao'] ?>">
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-pencil"></i> <span>Alterar <span class="sr-only">Secao <?= HTML::chars($secao['titulo']) ?></span></span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('inserir_texto_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Texto</span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('inserir_imagem_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Imagem</span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('inserir_formula_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Fórmula</span></a>
							</ul>
						</div>
					</div>
				</div>
				<div id="itens-secao-<?= $secao['id_secao'] ?>" class="collapse">
					<?php foreach ($secao['itens'] as $item): ?>
					<div class="row" style="margin: 10px 0">
						<div class="col-md-9">
							<?php if ($item['tipo'] == 'texto'): ?>
							<div><?= nl2br(HTML::chars($item['texto'])) ?></div>
							<?php elseif ($item['tipo'] == 'imagem'): ?>
							<div><?= HTML::chars($item['id_imagem']) ?></div>
							<?php elseif ($item['tipo'] == 'formula'): ?>
							<div><?= HTML::chars($item['id_formula']) ?></div>
							<?php endif ?>
						</div>
						<div class="col-md-3">
							<div class="text-muted">Opções</div>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>