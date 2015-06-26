<?= Form::open(Route::url('remover_texto_secao', array('id_aula' => $texto_secao['secao']['aula']['id_aula'], 'id_secao' => $texto_secao['secao']['id_secao'], 'id_secao_texto' => $texto_secao['id_secao_texto'], 'action' => 'salvar')), array('class' => 'form-horizontal')) ?>
	<p class="lead"><i class="glyphicon glyphicon-warning-sign"></i> Tem certeza que deseja remover este texto da seção?</p>
	<div class="form-group">
		<label for="remover-titulo" class="control-label col-lg-4">Texto:</label>
		<div class="col-lg-8">
			<?= Form::textarea('texto', $texto_secao['texto'], array('id' => 'remover-texto-secao', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-4 col-lg-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-trash"></i> Confirmar remoção', array('class' => 'btn btn-danger btn-lg')) ?>
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar_secoes', array('id_aula' => $texto_secao['secao']['aula']['id_aula'])) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
		</div>
	</div>
<?= Form::close() ?>