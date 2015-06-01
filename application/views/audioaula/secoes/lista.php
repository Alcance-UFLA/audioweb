<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<ul id="lista-secoes" class="list-group" role="list" aria-labelledby="titulo-principal">
			<?php foreach ($secoes['lista'] as $i => $secao): ?>
			<li class="list-group-item" role="listitem">
				<div class="row">
					<div class="col-md-9">
						<div class="lead"><?= HTML::chars($secao['numero']) ?> <?= HTML::chars($secao['titulo']) ?></div>
						<div class="text-muted">//TODO conteúdo da seção</div>
					</div>
					<div class="col-md-3">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" id="opcoes-secao-<?= $secao['id_secao'] ?>" data-toggle="dropdown" aria-expanded="false">
								Opções <span class="sr-only">da Seção <?= HTML::chars($secao['titulo']) ?></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="opcoes-secao-<?= $secao['id_secao'] ?>">
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar', array('directory' => 'audioaula', 'controller' => 'secoes', 'action' => 'alterar', 'id' => $aula['id_aula'], 'opcao1' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-pencil"></i> <span>Alterar <span class="sr-only">Secao <?= HTML::chars($secao['titulo']) ?></span></span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar', array('directory' => 'audioaula', 'controller' => 'secoes', 'action' => 'inserirtexto', 'id' => $aula['id_aula'], 'opcao1' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Texto</span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar', array('directory' => 'audioaula', 'controller' => 'secoes', 'action' => 'inseririmagem', 'id' => $aula['id_aula'], 'opcao1' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Imagem</span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar', array('directory' => 'audioaula', 'controller' => 'secoes', 'action' => 'inserirformula', 'id' => $aula['id_aula'], 'opcao1' => $secao['id_secao'])) ?>"><i class="glyphicon glyphicon-plus"></i> <span>Inserir Fórmula</span></a>
							</ul>
						</div>
					</div>
				</div>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>