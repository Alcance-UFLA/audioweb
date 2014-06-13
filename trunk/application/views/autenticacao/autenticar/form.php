<?= Helper_Mensagens::exibir($mensagens) ?>

<?= Form::open('autenticacao/autenticar/login/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<label for="autenticar-usuario" class="control-label col-lg-2">Usuário:</label>
		<div class="col-lg-4">
			<?= Form::input('usuario', HTML::chars(Arr::get($_POST, 'usuario')), array('id' => 'autenticar-usuario', 'class' => 'form-control', 'maxlength' => '45', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="autenticar-senha" class="control-label col-lg-2">Senha:</label>
		<div class="col-lg-4">
			<?= Form::input('senha', NULL, array('id' => 'autenticar-senha', 'class' => 'form-control', 'maxlength' => '45', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="autenticar-lembrar" class="control-label col-lg-2">Lembrar senha:</label>
		<div class="col-lg-4">
			<?= Form::checkbox('lembrar', HTML::chars(Arr::get($_POST, 'lembrar')), array('id' => 'autenticar-lembrar', 'class' => 'form-control')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-chevron-left"></i> Enviar', array('class' => 'btn btn-success btn-lg')) ?>
		</div>
	</div>
<?= Form::close(); ?>