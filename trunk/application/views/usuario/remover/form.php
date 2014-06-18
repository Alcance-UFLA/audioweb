<?= Helper_Mensagens::exibir($mensagens) ?>

<?= Form::open('usuario/remover/'.$usuario->id_usuario.'/salvar/', array('class' => 'form-horizontal')) ?>
	<p class="lead">Tem certeza que deseja remover este usuário?</p>
	<div class="form-group">
		<label for="remover-nome" class="control-label col-lg-2">Nome:</label>
		<div class="col-lg-4">
			<?= Form::input('nome', $usuario->nome, array('id' => 'remover-nome', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="remover-email" class="control-label col-lg-2">E-mail:</label>
		<div class="col-lg-4">
			<?= Form::input('email', $usuario->email, array('id' => 'remover-email', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-trash"></i> Confirmar remoção', array('class' => 'btn btn-danger btn-lg')) ?>
			<?= HTML::anchor('usuario/listar', '<i class="glyphicon glyphicon-chevron-left"></i> Voltar', array('class' => 'btn btn-default btn-lg')) ?>
		</div>
	</div>
<?= Form::close() ?>