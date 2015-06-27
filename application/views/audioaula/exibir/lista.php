<div class="row">
	<section class="col-md-8 col-md-offset-2 margem-inferior">

		<div class="panel panel-default margem-inferior">
			<div class="panel-heading">
				<div class="panel-title">Conteúdo desta Aula:</div>
			</div>
			<?php if ($aula['descricao']): ?>
			<div class="panel-body">
				<p><i class="text-muted"><?= HTML::chars($aula['descricao']) ?></i></p>
			</div>
			<?php endif ?>
			<div class="list-group">
				<?php foreach ($aula['secoes'] as $i => $secao): ?>
				<?php if ($i > 0): ?>
				<span class="sr-only">,</span>
				<?php endif ?>
				<a class="list-group-item" href="#secao-<?= str_replace('.', '-', trim($secao['numero'], '.')) ?>">
					<?= HTML::chars($secao['numero']) ?> <?= HTML::chars($secao['titulo']) ?>
				</a>
				<?php endforeach ?>
			</div>
		</div>

		<?php foreach ($aula['secoes'] as $i => $secao): ?>
		<?php if ($i > 0 && $secao['nivel'] == 1): ?>
		<hr />
		<?php endif ?>
		<a id="secao-<?= str_replace('.', '-', trim($secao['numero'], '.')) ?>" style="position: relative; top: -50px;"></a>
		<article>
			<header>
				<?= sprintf('<h%d>', $secao['nivel']) ?>
				<?= HTML::chars($secao['numero']) ?> <?= HTML::chars($secao['titulo']) ?>
				<?= sprintf('</h%d>', $secao['nivel']) ?>
			</header>
			<div class="content">
				<?php foreach ($secao['itens'] as $item): ?>
				<?php if ($item['tipo'] == 'Model_Secao_Texto'): ?>
				<p><?= HTML::chars($item['texto']) ?></p>
				<?php endif ?>
				<?php endforeach ?>
			</div>
		</article>
		<?php endforeach ?>
	</section>
</div>