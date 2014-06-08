<?= Form::open('usuario/inserir/salvar/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<label for="inserir-nome" class="control-label col-lg-2">Nome:</label>
		<div class="col-lg-4">
			<?= Form::input('nome', '', array('id' => 'inserir-nome', 'class' => 'form-control')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="inserir-login" class="control-label col-lg-2">Login:</label>
		<div class="col-lg-4">
			<?= Form::input('usuario', '', array('id' => 'inserir-login', 'class' => 'form-control')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-10">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-plus"></i> Adicionar', array('class' => 'btn btn-success btn-lg')) ?>
			<?= HTML::anchor('usuario/listar', '<i class="glyphicon glyphicon-chevron-left"></i> Voltar', array('class' => 'btn btn-default btn-lg')) ?>
		</div>
	</div>
<?= Form::close(); ?>