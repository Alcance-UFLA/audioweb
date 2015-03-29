<?= Form::open('usuario/cadastrar/salvar/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<?= Form::label('cadastrar-nome', 'Nome:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('nome', Arr::get($form_usuario['dados'], 'nome'), array('id' => 'cadastrar-nome', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'autofocus' => 'autofocus', 'placeholder' => 'Seu nome', 'autocomplete' => 'off')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('cadastrar-email', 'E-mail:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('email', Arr::get($form_usuario['dados'], 'email'), array('type' => 'email', 'id' => 'cadastrar-email', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Seu e-mail', 'autocomplete' => 'off')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('cadastrar-senha', 'Senha:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::password('senha', '', array('id' => 'cadastrar-senha', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Digite uma senha')) ?>
		</div>
	</div>
	<div class="form-group margem-inferior">
		<?php HTML::start_block() ?>
		<?= HTML::header('Licença de Uso Gratuita', array('class' => 'h4 text-center')) ?>
		<div class="rolagem">
			<?= View::factory('partials/licenca_uso') ?>
		</div>
		<?php HTML::end_block();?>
	</div>
	<div class="form-group">
		<?php HTML::start_block() ?>
		<?= HTML::header('Política de Privacidade', array('class' => 'h4 text-center')) ?>
		<div class="rolagem">
			<?= View::factory('partials/politica_privacidade') ?>
		</div>
		<?php HTML::end_block();?>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<div class="checkbox">
				<label>
					<?= Form::checkbox('concordar', '1', (bool)Arr::get($form_usuario['dados'], 'concordar'), array('id' => 'cadastrar-concordar')) ?>
					<span>Concordo com a Licença de Uso Gratuita e com a Política de Privacidade do AudioWeb.</span>
				</label>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-plus"></i> Cadastrar <span class="sr-only">Usuário</span>', array('class' => 'btn btn-success btn-lg')) ?>
		</div>
	</div>
<?= Form::close(); ?>