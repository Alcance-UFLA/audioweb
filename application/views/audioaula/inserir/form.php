<?= Form::open(Route::url('acao_padrao', array('directory' => 'audioaula', 'controller' => 'inserir', 'action' => 'salvar')), array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<?= Form::label('inserir-nome', 'Nome:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('nome', Arr::get($form_aula['dados'], 'nome'), array('id' => 'inserir-nome', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Nome breve')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-descricao', 'Descrição:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::textarea('descricao', Arr::get($form_aula['dados'], 'descricao'), array('id' => 'inserir-descricao', 'class' => 'form-control', 'cols' => '50', 'rows' => '4', 'required' => 'required', 'placeholder' => 'Descrição longa')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-rotulos', 'Rótulos:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('rotulos', Arr::get($form_aula['dados'], 'rotulos'), array('id' => 'inserir-rotulos', 'class' => 'form-control', 'maxlength' => '256', 'placeholder' => 'Rótulos separados por vírgula')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-plus"></i> Inserir <span class="sr-only">nova aula</span>', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar', array('directory' => 'audioaula')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a lista de aulas</span></a>
		</div>
	</div>
<?= Form::close(); ?>
