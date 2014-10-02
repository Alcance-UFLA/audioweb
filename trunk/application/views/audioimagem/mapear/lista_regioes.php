<div class="panel panel-primary">
	<div class="panel-heading">
		<h2 class="panel-title">Regiões Mapeadas</h2>
	</div>
	<div class="panel-body">
		<?php if ($form_imagem['dados']['regioes']): ?>
		<ul>
			<?php foreach ($form_imagem['dados']['regioes'] as $regiao): ?>
			<li class="dados-regiao" data-id-imagem-regiao="<?= $regiao['id_imagem_regiao'] ?>">
				<span class="nome"><?= HTML::chars($regiao['nome']) ?></span>
			</li>
			<?php endforeach ?>
		</ul>
		<?php else: ?>
		<p class="text-muted">Nenhuma região mapeada.</p>
		<?php endif ?>
	</div>
</div>