<?= Helper_Mensagens::exibir($mensagens) ?>

<?= Form::open('autenticacao/autenticar/login/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<label for="autenticar-email" class="control-label col-lg-2">E-mail:</label>
		<div class="col-lg-4">
			<?= Form::input('email', HTML::chars(Arr::get($_POST, 'email')), array('id' => 'autenticar-email', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="autenticar-senha" class="control-label col-lg-2">Senha:</label>
		<div class="col-lg-4">
			<?= Form::input('senha', NULL, array('id' => 'autenticar-senha', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'type' => 'password')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<div class="checkbox">
				<label>
					<?= Form::checkbox('lembrar', HTML::chars(Arr::get($_POST, 'lembrar')), array('id' => 'autenticar-lembrar', 'class' => 'form-control')) ?>
					<span>Manter conectado</span>
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-log-in"></i> Enviar', array('class' => 'btn btn-success btn-lg')) ?>
		</div>
	</div>
<?= Form::close(); ?>