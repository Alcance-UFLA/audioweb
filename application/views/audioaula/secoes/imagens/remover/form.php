<?= Form::open(Route::url('remover_imagem_secao', array('id_aula' => $imagem_secao['secao']['aula']['id_aula'], 'id_secao' => $imagem_secao['secao']['id_secao'], 'id_secao_imagem' => $imagem_secao['id_secao_imagem'], 'action' => 'salvar')), array('class' => 'form-horizontal')) ?>
	<p class="lead"><i class="glyphicon glyphicon-warning-sign"></i> Tem certeza que deseja remover esta imagem da seção?</p>
	<div class="form-group">
		<label for="remover-nome" class="control-label col-lg-4">Nome:</label>
		<div class="col-lg-8">
			<?= Form::input('nome', $imagem_secao['imagem']['nome'], array('id' => 'remover-nome', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<label for="remover-imagem" class="control-label col-lg-4">Imagem:</label>
		<div class="col-lg-8">
			<img alt="<?= HTML::chars($imagem_secao['imagem']['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $imagem_secao['imagem']['id_conta'], 'nome' => $imagem_secao['imagem']['arquivo'], 'tamanho' => '300x300')) ?>" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-offset-4 col-lg-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-trash"></i> Confirmar remoção', array('class' => 'btn btn-danger btn-lg')) ?>
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar_secoes', array('id_aula' => $imagem_secao['secao']['aula']['id_aula'])) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>
		</div>
	</div>
<?= Form::close() ?>