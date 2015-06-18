<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<ul id="lista-secoes" class="list-group" role="list" aria-labelledby="titulo-principal" data-action-salvar-posicoes="<?= Route::url('listar_secoes', array('id_aula' => $aula['id_aula'], 'action' => 'salvarposicoes')) ?>">
			<?php foreach ($secoes['lista'] as $i => $secao): ?>
			<li id="secao-<?= $secao['id_secao'] ?>" class="secao list-group-item" role="listitem" data-id-secao="<?= $secao['id_secao'] ?>" data-posicao="<?= $secao['posicao'] ?>">
				<div id="titulo-secao-<?= $secao['id_secao'] ?>" class="titulo-secao row">
					<div class="col-md-1">
						<div class="tipo-secao">
							<i class="glyphicon glyphicon-bookmark"></i><span class="hide">Seção</span>
						</div>
					</div>
					<div class="col-md-8">
						<div class="nome-secao">
							<?php if ($secao['itens']): ?>
							<a class="lead" data-toggle="collapse" data-parent="#lista-secoes" href="#lista-itens-secao-<?= $secao['id_secao'] ?>" aria-expanded="false" aria-controls="lista-itens-secao-<?= $secao['id_secao'] ?>">
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
								<i class="glyphicon glyphicon-bookmark"></i>
								Opções <span class="sr-only">da Seção <?= HTML::chars($secao['titulo']) ?></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="opcoes-secao-<?= $secao['id_secao'] ?>">
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-pencil"></i> <span>Alterar Seção <span class="sr-only"><?= HTML::chars($secao['titulo']) ?></span></span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('remover_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-trash"></i> <span>Remover Seção <span class="sr-only"><?= HTML::chars($secao['titulo']) ?></span></span></a>
								<li role="presentation" class="divider"></li>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('inserir_texto_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Texto</span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('inserir_imagem_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Imagem</span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('inserir_formula_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Fórmula</span></a>
							</ul>
						</div>
					</div>
				</div>
				<ul style="margin-top: 10px;" id="lista-itens-secao-<?= $secao['id_secao'] ?>" class="collapse lista-itens-secao list-unstyled" role="list" aria-labelledby="titulo-secao-<?= $secao['id_secao'] ?>" data-id-secao="<?= $secao['id_secao'] ?>" data-action-salvar-posicoes="<?= Route::url('listar_secoes', array('id_aula' => $aula['id_aula'], 'action' => 'salvarposicoesitens')) ?>">
					<?php foreach ($secao['itens'] as $item): ?>
					<?php if ($item['tipo'] == 'texto'): ?>
					<li style="border-top: 1px solid #CCCCCC; padding: 10px 0; background-color: #FFFFFF;" id="item-secao-texto-<?= $item['id_secao_texto'] ?>" class="item-secao" role="listitem" data-id-item-secao="texto<?= $item['id_secao_texto'] ?>" data-posicao="<?= $item['posicao'] ?>">
						<div id="titulo-item-secao-texto-<?= $item['id_secao_texto'] ?>" class="titulo-item-secao row">
							<div class="col-md-1">
								<div class="tipo-item-secao">
									<i class="glyphicon glyphicon-list"></i><span class="hide">Texto</span>
								</div>
							</div>
							<div class="col-md-8">
								<div class="secao-texto"><?= nl2br(HTML::chars($item['texto'])) ?></div>
							</div>
							<div class="col-md-3">
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle" type="button" id="opcoes-texto-<?= $item['id_secao_texto'] ?>" data-toggle="dropdown" aria-expanded="false">
										<i class="glyphicon glyphicon-list"></i>
										Opções <span class="sr-only">do texto</span>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu" aria-labelledby="opcoes-texto-<?= $item['id_secao_texto'] ?>">
										<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar_texto_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'], 'id_secao_texto' => $item['id_secao_texto'])) ?>"><i class="glyphicon glyphicon-pencil"></i> <span>Alterar Texto</span></a>
										<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('remover_texto_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'], 'id_secao_texto' => $item['id_secao_texto'])) ?>"><i class="glyphicon glyphicon-trash"></i> <span>Remover Texto</span></a>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<?php elseif ($item['tipo'] == 'imagem'): ?>
					//TODO
					<?php elseif ($item['tipo'] == 'formula'): ?>
					//TODO
					<?php endif ?>
					<?php endforeach ?>
				</ul>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>