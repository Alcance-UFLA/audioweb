<table class="table table-bordered table-striped table-hover">
	<caption>Lista de usuários</caption>
	<thead>
		<tr>
			<th>ID</th>
			<th>Login</th>
			<th>Nome</th>
			<th>Opções</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($usuarios as $usuario): ?>
		<tr>
			<td><?= HTML::entities($usuario->id) ?></td>
			<td><?= HTML::entities($usuario->usuario) ?></td>
			<td><?= HTML::entities($usuario->nome) ?></td>
			<td>
				<div class="btn-group">
					<?= HTML::anchor('usuario/alterar/'.$usuario->id, '<i class="glyphicon glyphicon-pencil"></i> <span class="visible-xs">Editar</span>', array('class' => 'btn btn-default btn-sm')) ?>
					<?= HTML::anchor('usuario/remover/'.$usuario->id, '<i class="glyphicon glyphicon-trash"></i> <span class="visible-xs">Remover</span>', array('class' => 'btn btn-default btn-sm', 'onclick' => 'return confirm("Você deseja remover o registro?")')) ?>
				</div>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>