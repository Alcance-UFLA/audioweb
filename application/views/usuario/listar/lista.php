<table class="table table-bordered table-striped table-hover">
	<caption>Lista de usuários</caption>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nome</th>
			<th>E-mail</th>
			<th>Opções</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($usuarios as $usuario): ?>
		<tr>
			<td><?= HTML::chars($usuario->id_usuario) ?></td>
			<td><?= HTML::chars($usuario->nome) ?></td>
			<td><?= HTML::chars($usuario->email) ?></td>
			<td>
				<div class="btn-group">
					<a class="btn btn-default btn-sm btn-alterar" href="<?= Route::url('acao_id', array('directory' => 'usuario', 'controller' => 'alterar', 'id' => $usuario->id_usuario)) ?>"><i class="glyphicon glyphicon-pencil"></i> <span class="visible-xs">Alterar</span></a>
					<a class="btn btn-default btn-sm btn-remover" href="<?= Route::url('acao_id', array('directory' => 'usuario', 'controller' => 'remover', 'id' => $usuario->id_usuario)) ?>"><i class="glyphicon glyphicon-trash"></i> <span class="visible-xs">Remover</span></a>
				</div>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>