<table class="table table-bordered table-striped table-hover">
	<caption>Lista de imagens</caption>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nome</th>
			<th>Data de Criação</th>
			<th>Opções</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($imagens['lista'] as $imagem): ?>
		<tr>
			<td><?= HTML::entities($imagem->id_imagem) ?></td>
			<td><?= HTML::entities($imagem->nome) ?></td>
			<td><?= HTML::entities($imagem->data_cadastro) ?></td>
			<td>
				<div class="btn-group">
					<?= HTML::anchor('audioimagem/alterar/'.$imagem->id_imagem, '<i class="glyphicon glyphicon-pencil"></i> <span class="visible-xs">Alterar</span>', array('class' => 'btn btn-default btn-sm btn-alterar')) ?>
				</div>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>