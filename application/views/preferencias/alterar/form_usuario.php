<div class="form-group">
	<?= Form::label('alterar-usuario-nome', 'Nome:', array('class' => 'control-label col-md-4')) ?>
	<div class="col-md-8">
		<?= Form::input('usuario[nome]', Arr::get($form_preferencias['dados']['usuario'], 'nome'), array('id' => 'alterar-usuario-nome', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Nome')) ?>
	</div>
</div>
<div class="form-group">
	<?= Form::label('alterar-usuario-email', 'E-mail:', array('class' => 'control-label col-md-4')) ?>
	<div class="col-md-8">
		<?= Form::input('usuario[email]', Arr::get($form_preferencias['dados']['usuario'], 'email'), array('id' => 'alterar-usuario-email', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'E-mail')) ?>
	</div>
</div>