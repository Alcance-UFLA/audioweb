<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<ul id="lista-secoes" class="list-group" role="list" aria-labelledby="titulo-principal">
			<?php foreach ($secoes['lista'] as $i => $secao): ?>
			<li id="secao<?= $secao['id_secao'] ?>" class="list-group-item" role="listitem">
				<div id="titulo-secao<?= $secao['id_secao'] ?>" class="row">
					<div class="col-md-9">
						<div class="lead">
							<a data-toggle="collapse" href="#itens-secao-<?= $secao['id_secao'] ?>" aria-expanded="false" aria-controls="itens-secao-<?= $secao['id_secao'] ?>">
								<?= HTML::chars($secao['numero']) ?> <?= HTML::chars($secao['titulo']) ?>
							</a>
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
					<div class="row">
						<div class="col-md-9">
							<?php if ($item['tipo'] == 'texto'): ?>
							<div><?= HTML::chars($item['texto']) ?></div>
							<?php elseif ($item['tipo'] == 'imagem'): ?>
							<?php elseif ($item['tipo'] == 'formula'): ?>
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