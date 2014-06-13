<?= Helper_Mensagens::exibir($mensagens) ?>

<?= Form::open('usuario/inserir/salvar/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<label for="inserir-nome" class="control-label col-lg-2">Nome:</label>
		<div class="col-lg-4">
			<?= Form::input('nome', $usuario->nome, array('id' => 'inserir-nome', 'class' => 'form-control', 'maxlength' => '45', 'required' => 'required')) ?>
		</div>
	</div>
	<!-- TODO: configurar campos corretamente -->
	<div class="form-group">
		<label for="inserir-login" class="control-label col-lg-2">Login (Remover):</label>
		<div class="col-lg-4">
			<?= Form::input('usuario', $usuario->usuario, array('id' => 'inserir-login', 'class' => 'form-control', 'maxlength' => '45', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inserir-username" class="control-label col-lg-2">Login:</label>
		<div class="col-lg-4">
			<?= Form::input('username', NULL, array('id' => 'inserir-username', 'class' => 'form-control', 'maxlength' => '45', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inserir-email" class="control-label col-lg-2">E-mail:</label>
		<div class="col-lg-4">
			<?= Form::input('email', NULL, array('id' => 'inserir-email', 'class' => 'form-control', 'maxlength' => '45', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inserir-password" class="control-label col-lg-2">Senha:</label>
		<div class="col-lg-4">
			<?= Form::password('password', NULL, array('id' => 'inserir-password', 'class' => 'form-control', 'maxlength' => '45', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inserir-password_confirm" class="control-label col-lg-2">Confirmar Senha:</label>
		<div class="col-lg-4">
			<?= Form::password('password_confirm', NULL, array('id' => 'inserir-password_confirm', 'class' => 'form-control', 'maxlength' => '45', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-plus"></i> Adicionar', array('class' => 'btn btn-success btn-lg')) ?>
			<?= HTML::anchor('usuario/listar', '<i class="glyphicon glyphicon-chevron-left"></i> Voltar', array('class' => 'btn btn-default btn-lg')) ?>
		</div>
	</div>
<?= Form::close(); ?>