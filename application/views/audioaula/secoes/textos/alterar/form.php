<?= Form::open(Route::url('alterar_texto_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'], 'id_secao_texto' => $form_texto['dados']['id_secao_texto'], 'action' => 'salvar')), array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<?= Form::label('alterar-aula', 'Aula:', array('class' => 'control-label col-md-2')) ?>
		<div class="col-md-10">
			<?= Form::input('aula', $aula['nome'], array('id' => 'alterar-aula', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-secao', 'Seção:', array('class' => 'control-label col-md-2')) ?>
		<div class="col-md-10">
			<?= Form::input('secao', $secao['titulo'], array('id' => 'alterar-secao', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-texto', 'Texto:', array('class' => 'control-label col-md-2')) ?>
		<div class="col-md-10">
			<?= Form::textarea('texto', Arr::get($form_texto['dados'], 'texto'), array('id' => 'alterar-texto', 'class' => 'form-control', 'cols' => 50, 'rows' => 10, 'required' => 'required', 'placeholder' => 'Texto da seção')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-pencil"></i> Alterar <span class="sr-only">texto</span>', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar_secoes', array('id_aula' => $aula['id_aula'])) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a preparação de aula</span></a>
		</div>
	</div>
<?= Form::close(); ?>
