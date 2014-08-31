<?= Form::open('autenticacao/autenticar/login/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<label for="autenticar-email" class="control-label col-md-4">E-mail:</label>
		<div class="col-md-8">
			<?= Form::input('email', HTML::chars(Arr::get($_POST, 'email')), array('id' => 'autenticar-email', 'class' => 'form-control', 'maxlength' => '128', 'placeholder' => 'Seu e-mail', 'required' => 'required', 'autofocus' => 'autofocus')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="autenticar-senha" class="control-label col-md-4">Senha:</label>
		<div class="col-md-8">
			<?= Form::input('senha', NULL, array('id' => 'autenticar-senha', 'class' => 'form-control', 'maxlength' => '128', 'placeholder' => 'Sua senha', 'required' => 'required', 'type' => 'password')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-12">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-log-in"></i> Entrar', array('class' => 'btn btn-primary btn-lg btn-block')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<div class="checkbox">
				<label>
					<?= Form::checkbox('lembrar', '1', HTML::chars(Arr::get($_POST, 'lembrar')), array('id' => 'autenticar-lembrar')) ?>
					<span>Manter conectado</span>
				</label>
			</div>
		</div>
		<div class="col-md-6">
			<div style="margin-top: 7px;">
				<?= HTML::anchor('#TODO', 'Esqueceu a senha?') ?>
			</div>
		</div>
	</div>
<?= Form::close(); ?>