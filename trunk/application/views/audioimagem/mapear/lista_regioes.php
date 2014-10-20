<div class="panel panel-primary panel-lista-regioes">
	<div class="panel-heading">
		<h2 class="panel-title">Regiões Mapeadas</h2>
	</div>
	<div class="panel-body">
		<?php if ($form_imagem['dados']['regioes']): ?>
		<ul id="lista-regioes" class="list-unstyled" data-id-imagem="<?= $form_imagem['dados']['imagem']['id_imagem'] ?>" data-action-salvar-posicoes="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $form_imagem['dados']['imagem']['id_imagem'], 'action' => 'regiao', 'opcao1' => 'posicoes', 'opcao2' => 'salvar')) ?>">
			<?php foreach ($form_imagem['dados']['regioes'] as $regiao): ?>
			<li class="dados-regiao <?= $regiao['id_imagem_regiao'] == $form_imagem['dados']['regiao']['id_imagem_regiao'] ? 'regiao-alteracao' : '' ?>" data-id-imagem-regiao="<?= $regiao['id_imagem_regiao'] ?>" data-nome="<?= HTML::chars($regiao['nome']) ?>" data-descricao="<?= HTML::chars($regiao['descricao']) ?>" data-tipo-regiao="<?= HTML::chars($regiao['tipo_regiao']) ?>" data-posicao="<?= HTML::chars($regiao['posicao']) ?>" data-coordenadas="<?= HTML::chars($regiao['coordenadas']) ?>">
				<div class="container-fluid">
				<div class="row">
					<span class="col-lg-5 area-nome-regiao">
						<span class="nome-regiao" title="Região <?= HTML::chars($regiao['nome']) ?>"><?= HTML::chars($regiao['nome']) ?></span>
					</span>
					<span class="col-lg-7">
						<span class="btn-group">
							<a class="btn btn-default btn-sm btn-alterar" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $form_imagem['dados']['imagem']['id_imagem'], 'action' => 'regiao', 'opcao1' => 'alterar', 'opcao2' => $regiao['id_imagem_regiao'])) ?>"><i class="glyphicon glyphicon-pencil"></i> Alterar <span class="sr-only">região <?= HTML::chars($regiao['nome']) ?></span></a>
							<a class="btn btn-default btn-sm btn-remover" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $form_imagem['dados']['imagem']['id_imagem'], 'action' => 'regiao', 'opcao1' => 'remover', 'opcao2' => $regiao['id_imagem_regiao'])) ?>"><i class="glyphicon glyphicon-trash"></i> Remover <span class="sr-only">região <?= HTML::chars($regiao['nome']) ?></span></a>
						</span>
					</span>
				</div>
				</div>
			</li>
			<?php endforeach ?>
		</ul>
		<?php else: ?>
		<p class="text-muted text-center">Nenhuma região mapeada.</p>
		<?php endif ?>
	</div>
</div>