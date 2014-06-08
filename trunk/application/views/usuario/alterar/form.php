<?= Helper_Mensagens::exibir($mensagens) ?>

<?= Form::open('usuario/alterar/'.$usuario->id.'/salvar/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<label for="alterar-nome" class="control-label col-lg-2">Nome:</label>
		<div class="col-lg-4">
			<?= Form::input('nome', $usuario->nome, array('id' => 'alterar-nome', 'class' => 'form-control', 'maxlength' => 45, 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="alterar-login" class="control-label col-lg-2">Login:</label>
		<div class="col-lg-4">
			<?= Form::input('usuario', $usuario->usuario, array('id' => 'alterar-login', 'class' => 'form-control', 'maxlength' => 45, 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-pencil"></i> Alterar', array('class' => 'btn btn-primary btn-lg')) ?>
			<?= HTML::anchor('usuario/listar', '<i class="glyphicon glyphicon-chevron-left"></i> Voltar', array('class' => 'btn btn-default btn-lg')) ?>
		</div>
	</div>
<?= Form::close() ?>