<table class="table table-bordered table-striped table-hover">
	<caption>Lista de imagens</caption>
	<thead>
		<tr>
			<th scope="col">Miniatura</th>
			<th scope="col">Nome</th>
			<th scope="col">Data de Criação</th>
			<th scope="col">Opções</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($imagens['lista'] as $imagem): ?>
		<tr>
			<td><img src="<?= Route::url('exibir_imagem', array('conta' => $imagem->usuario->id_conta, 'nome' => $imagem->arquivo, 'tamanho' => '50x50')) ?>" alt="<?= HTML::chars($imagem->nome) ?>" /></td>
			<td><?= HTML::chars($imagem->nome) ?></td>
			<td><?= HTML::chars(Date::formatted_time($imagem->data_cadastro, 'd/m/Y - H:i:s')) ?></td>
			<td>
				<div class="btn-group">
					<?= HTML::anchor('audioimagem/alterar/'.$imagem->id_imagem, '<i class="glyphicon glyphicon-pencil"></i> <span>Alterar</span>', array('class' => 'btn btn-default btn-sm btn-alterar')) ?>
				</div>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>