<?= Form::open('audioaula/alterar/' . $form_aula['dados']['id_aula'] . '/salvar/', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<?= Form::label('alterar-nome', 'Nome:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('nome', Arr::get($form_aula['dados'], 'nome'), array('id' => 'alterar-nome', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Nome breve')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-descricao', 'Descrição:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::textarea('descricao', Arr::get($form_aula['dados'], 'descricao'), array('id' => 'alterar-descricao', 'class' => 'form-control', 'cols' => '50', 'rows' => '4', 'required' => 'required', 'placeholder' => 'Descrição longa')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-rotulos', 'Rótulos:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('rotulos', Arr::get($form_aula['dados'], 'rotulos'), array('id' => 'alterar-rotulos', 'class' => 'form-control', 'maxlength' => '256', 'placeholder' => 'Rótulos separados por vírgula')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-pencil"></i> Alterar <span class="sr-only">dados da aula</span>', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar', array('directory' => 'audioaula')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a lista de aulas</span></a>
		</div>
	</div>
<?= Form::close(); ?>
