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
			<td><?= HTML::entities($usuario->id_usuario) ?></td>
			<td><?= HTML::entities($usuario->nome) ?></td>
			<td><?= HTML::entities($usuario->email) ?></td>
			<td>
				<div class="btn-group">
					<?= HTML::anchor('usuario/alterar/'.$usuario->id_usuario, '<i class="glyphicon glyphicon-pencil"></i> <span class="visible-xs">Alterar</span>', array('class' => 'btn btn-default btn-sm btn-alterar')) ?>
					<?= HTML::anchor('usuario/remover/'.$usuario->id_usuario, '<i class="glyphicon glyphicon-trash"></i> <span class="visible-xs">Remover</span>', array('class' => 'btn btn-default btn-sm btn-remover')) ?>
				</div>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>