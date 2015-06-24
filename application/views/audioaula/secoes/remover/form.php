<?= Form::open(Route::url('remover_secao', array('id_aula' => $aula['id_aula'], 'id_secao' => $secao['id_secao'], 'action' => 'salvar')), array('class' => 'form-horizontal')) ?>
	<p class="lead"><i class="glyphicon glyphicon-warning-sign"></i> Tem certeza que deseja remover esta seção e todo seu conteúdo?</p>
	<div class="form-group">
		<label for="remover-titulo" class="control-label col-lg-4">Nome:</label>
		<div class="col-lg-8">
			<?= Form::input('titulo', $secao['titulo'], array('id' => 'remover-titulo', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-4 col-lg-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-trash"></i> Confirmar remoção', array('class' => 'btn btn-danger btn-lg')) ?>
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar_secoes', array('id_aula' => $aula['id_aula'])) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
		</div>
	</div>
<?= Form::close() ?>