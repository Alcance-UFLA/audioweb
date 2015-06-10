<?= Form::open('audioaula/secoes/' . $aula['id_aula'] . '/inserir/salvar', array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<?= Form::label('inserir-titulo', 'Título:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('titulo', Arr::get($form_secao['dados'], 'titulo'), array('id' => 'inserir-titulo', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Título da Seção')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-nivel', 'Nível:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::select('nivel', array('' => 'Escolha') + $form_secao['lista_niveis'], Arr::get($form_secao['dados'], 'nivel'), array('id' => 'inserir-nivel', 'class' => 'form-control', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-plus"></i> Inserir <span class="sr-only">nova seção</span>', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar_secoes', array('id_aula' => $aula['id_aula'])) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a preparação de aula</span></a>
		</div>
	</div>
<?= Form::close(); ?>
