<?= Form::open(Route::url('acao_id', array('directory' => 'audioaula', 'controller' => 'remover', 'action' => 'salvar', 'id' => $aula['id_aula'])), array('class' => 'form-horizontal')) ?>
	<p class="lead"><i class="glyphicon glyphicon-warning-sign"></i> Tem certeza que deseja remover esta aula e todo seu conteúdo?</p>
	<div class="form-group">
		<label for="remover-nome" class="control-label col-lg-4">Nome:</label>
		<div class="col-lg-8">
			<?= Form::input('nome', $aula['nome'], array('id' => 'remover-nome', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-4 col-lg-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-trash"></i> Confirmar remoção', array('class' => 'btn btn-danger btn-lg')) ?>
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar', array('directory' => 'audioaula')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
		</div>
	</div>
<?= Form::close() ?>