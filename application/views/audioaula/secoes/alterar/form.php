<?= Form::open(Route::url('alterar_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $form_secao['dados']['id_secao'], 'action' => 'salvar')), array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<?= Form::label('alterar-titulo', 'Título:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('titulo', Arr::get($form_secao['dados'], 'titulo'), array('id' => 'alterar-titulo', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Título da Seção')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-nivel', 'Nível:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::select('nivel', array('' => 'Escolha') + $form_secao['lista_niveis'], Arr::get($form_secao['dados'], 'nivel'), array('id' => 'alterar-nivel', 'class' => 'form-control', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-pencil"></i> Alterar <span class="sr-only">seção</span>', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar_secoes', array('id_aula' => $aula['id_aula'])) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a preparação de aula</span></a>
		</div>
	</div>
<?= Form::close(); ?>
