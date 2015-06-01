<?php
$primeiro_registro = ($aulas['paginacao']['pagina'] - 1) * $aulas['paginacao']['itens_pagina'];
?>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<ul id="lista-aulas" class="list-group" role="list" aria-labelledby="titulo-principal">
			<?php foreach ($aulas['lista'] as $i => $aula): ?>
			<li class="list-group-item" role="listitem" aria-setsize="<?= number_format($aulas['paginacao']['total_registros'], 0, '.', '') ?>" aria-posinset="<?= number_format($primeiro_registro + $i + 1, 0, '.', '') ?>">
				<div class="row">
					<div class="col-md-9">
						<a class="nome-aula lead" href="<?= Route::URL('alterar', array('directory' => 'audioaula', 'controller' => 'exibir', 'action' => 'index', 'id' => $aula['id_aula'])) ?>"><?= HTML::chars($aula['nome']) ?></a>
					</div>
					<div class="col-md-3">
						<div class="dropdown">
							<button class="btn btn-default dropdown-toggle" type="button" id="opcoes-aula-<?= $aula['id_aula'] ?>" data-toggle="dropdown" aria-expanded="false">
								Opções <span class="sr-only">da Aula <?= HTML::chars($aula['nome']) ?></span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="opcoes-aula-<?= $aula['id_aula'] ?>">
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar', array('directory' => 'audioaula', 'controller' => 'alterar', 'action' => 'index', 'id' => $aula['id_aula'])) ?>"><i class="glyphicon glyphicon-pencil"></i> <span>Alterar <span class="sr-only">Aula <?= HTML::chars($aula['nome']) ?></span></span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar', array('directory' => 'audioaula', 'controller' => 'secoes', 'action' => 'index', 'id' => $aula['id_aula'])) ?>"><i class="glyphicon glyphicon-list-alt"></i> <span>Preparar <span class="sr-only">Aula <?= HTML::chars($aula['nome']) ?></span></span></a>
								<li role="presentation"><a class="menuitem" tabindex="-1" href="<?= Route::URL('alterar', array('directory' => 'audioaula', 'controller' => 'exibir', 'action' => 'index', 'id' => $aula['id_aula'])) ?>"><i class="glyphicon glyphicon-eye-open"></i> <span>Exibir <span class="sr-only">Aula <?= HTML::chars($aula['nome']) ?></span></span></a>
							</ul>
						</div>
					</div>
				</div>
			</li>
			<?php endforeach ?>
		</ul>
	</div>
</div>