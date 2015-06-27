<div class="form-group">
	<?= Form::label('alterar-usuario-senha-atual', 'Senha Atual:', array('class' => 'control-label col-md-4')) ?>
	<div class="col-md-8">
		<?= Form::input('usuario[senha_atual]', '', array('id' => 'alterar-usuario-senha_atual', 'class' => 'form-control', 'maxlength' => '128', 'placeholder' => 'Senha Atual', 'type' => 'password', 'autocomplete' => 'off')) ?>
	</div>
</div>
<div class="form-group">
	<?= Form::label('alterar-usuario-senha', 'Nova Senha:', array('class' => 'control-label col-md-4')) ?>
	<div class="col-md-8">
		<?= Form::input('usuario[senha]', '', array('id' => 'alterar-usuario-senha', 'class' => 'form-control', 'maxlength' => '128', 'placeholder' => 'Nova Senha', 'type' => 'password', 'autocomplete' => 'off')) ?>
	</div>
</div>
<div class="form-group">
	<?= Form::label('alterar-usuario-senha-confirmacao', 'Confirmação da Senha:', array('class' => 'control-label col-md-4')) ?>
	<div class="col-md-8">
		<?= Form::input('usuario[senha_confirmacao]', '', array('id' => 'alterar-usuario-senha-confirmacao', 'class' => 'form-control', 'maxlength' => '128', 'placeholder' => 'Confirmação da Nova Senha', 'type' => 'password', 'autocomplete' => 'off')) ?>
	</div>
</div>