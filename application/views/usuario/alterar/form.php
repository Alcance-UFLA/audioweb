<?= Helper_Mensagens::exibir($mensagens) ?>

<?= Form::open('usuario/alterar/'.$usuario->id_usuario.'/salvar/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<label for="alterar-nome" class="control-label col-lg-2">Nome:</label>
		<div class="col-lg-4">
			<?= Form::input('nome', $usuario->nome, array('id' => 'alterar-nome', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="alterar-email" class="control-label col-lg-2">E-mail:</label>
		<div class="col-lg-4">
			<?= Form::input('email', $usuario->email, array('id' => 'alterar-email', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-pencil"></i> Alterar', array('class' => 'btn btn-primary btn-lg')) ?>
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar', array('directory' => 'usuario')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
		</div>
	</div>
<?= Form::close() ?>