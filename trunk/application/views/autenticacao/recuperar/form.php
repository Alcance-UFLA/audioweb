<?= Form::open('autenticacao/recuperar/processar/', array('class' => 'form-horizontal')) ?>
	<div class="form-group form-group-lg">
		<?= Form::label('recuperar-email', 'E-mail:', array('class' => 'control-label col-md-3')) ?>
		<div class="col-md-9">
			<?= Form::input('email', Arr::get($form_recuperar['dados'], 'email'), array('id' => 'recuperar-email', 'class' => 'form-control', 'maxlength' => '128', 'placeholder' => 'Seu e-mail', 'required' => 'required', 'autofocus' => 'autofocus', 'autocomplete' => 'off')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-12">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-lock"></i> Recuperar Acesso', array('class' => 'btn btn-primary btn-lg btn-block')) ?>
		</div>
	</div>
<?= Form::close(); ?>