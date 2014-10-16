<div class="panel panel-primary">
	<div class="panel-heading">
		<h2 class="panel-title">Regiões Mapeadas</h2>
	</div>
	<div class="panel-body">
		<?php if ($form_imagem['dados']['regioes']): ?>
		<ul id="lista-regioes" class="list-unstyled" data-id-imagem="<?= $form_imagem['dados']['imagem']['id_imagem'] ?>">
			<?php foreach ($form_imagem['dados']['regioes'] as $regiao): ?>
			<li class="dados-regiao" data-id-imagem-regiao="<?= $regiao['id_imagem_regiao'] ?>" data-nome="<?= HTML::chars($regiao['nome']) ?>" data-descricao="<?= HTML::chars($regiao['descricao']) ?>" data-tipo-regiao="<?= HTML::chars($regiao['tipo_regiao']) ?>" data-posicao="<?= HTML::chars($regiao['posicao']) ?>" data-coordenadas="<?= HTML::chars($regiao['coordenadas']) ?>">
				<div class="row">
					<span class="col-lg-5 area-nome-regiao">
						<span class="nome-regiao" title="Região <?= HTML::chars($regiao['nome']) ?>"><?= HTML::chars($regiao['nome']) ?></span>
					</span>
					<span class="col-lg-7">
						<span class="btn-group">
							<a class="btn btn-default btn-sm btn-alterar"><i class="glyphicon glyphicon-pencil"></i> Alterar <span class="sr-only">região <?= HTML::chars($regiao['nome']) ?></span></a>
							<a class="btn btn-default btn-sm btn-remover"><i class="glyphicon glyphicon-trash"></i> Remover <span class="sr-only">região <?= HTML::chars($regiao['nome']) ?></span></a>
						</span>
					</span>
				</div>
			</li>
			<?php endforeach ?>
		</ul>
		<?php else: ?>
		<p class="text-muted">Nenhuma região mapeada.</p>
		<?php endif ?>
	</div>
</div>