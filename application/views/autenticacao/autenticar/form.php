<?= Form::open('autenticacao/autenticar/login/', array('class' => 'form-horizontal')) ?>
	<div class="form-group form-group-lg">
		<?= Form::label('autenticar-email', 'E-mail:', array('class' => 'control-label col-md-3')) ?>
		<div class="col-md-9">
			<?= Form::input('email', Arr::get($form_autenticacao['dados'], 'email'), array('id' => 'autenticar-email', 'class' => 'form-control', 'maxlength' => '128', 'placeholder' => 'Seu e-mail', 'required' => 'required', 'autocomplete' => 'off')) ?>
		</div>
	</div>
	<div class="form-group form-group-lg">
		<?= Form::label('autenticar-senha', 'Senha:', array('class' => 'control-label col-md-3')) ?>
		<div class="col-md-9">
			<?= Form::input('senha', '', array('id' => 'autenticar-senha', 'class' => 'form-control', 'maxlength' => '128', 'placeholder' => 'Sua senha', 'required' => 'required', 'type' => 'password')) ?>
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
					<?= Form::checkbox('lembrar', '1', (bool)Arr::get($form_autenticacao['dados'], 'lembrar'), array('id' => 'autenticar-lembrar')) ?>
					<span>Manter conectado</span>
				</label>
			</div>
		</div>
		<div class="col-md-6">
			<div style="margin-top: 7px;">
				<a href="<?= Route::url('acao_padrao', array('directory' => 'autenticacao', 'controller' => 'recuperar')) ?>">Esqueceu a senha?</a>
			</div>
		</div>
	</div>
<?= Form::close(); ?>
