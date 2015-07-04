<?= Form::open(Route::url('inserir_imagem_secao', array('id_aula' => $secao['aula']['id_aula'], 'id_secao' => $secao['id_secao'], 'action' => 'salvar')), array('class' => 'form-horizontal')) ?>
	<div class="form-group">
		<?= Form::label('inserir-aula', 'Aula:', array('class' => 'control-label col-md-2')) ?>
		<div class="col-md-10">
			<?= Form::input('aula', $secao['aula']['nome'], array('id' => 'inserir-aula', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-secao', 'Seção:', array('class' => 'control-label col-md-2')) ?>
		<div class="col-md-10">
			<?= Form::input('secao', $secao['titulo'], array('id' => 'inserir-secao', 'class' => 'form-control', 'disabled' => 'disabled')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-imagem', 'Imagem:', array('class' => 'control-label col-md-2')) ?>
		<div class="col-md-10">
			<div class="lista-imagens">
				<ul class="list-unstyled">
					<?php foreach ($form_imagem['lista_imagens'] as $imagem): ?>
					<li>
						<label class="radio">
							<?= Form::radio('id_imagem', $imagem['id_imagem'], Arr::get($form_imagem['dados'], 'id_imagem') == $imagem['id_imagem']) ?>
							<img alt="<?= HTML::chars($imagem['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'], 'tamanho' => '80x80')) ?>" longdesc="<?= Route::url('acao_id', array('directory' => 'audioimagem', 'controller' => 'exibir', 'id' => $imagem['id_imagem'])) ?>" />
							<span class="valor-nome"><?= HTML::chars($imagem['nome']) ?></span>
						</label>
					</li>
					<?php endforeach ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-plus"></i> Inserir <span class="sr-only">imagem na seção</span>', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar_secoes', array('id_aula' => $secao['aula']['id_aula'])) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a preparação de aula</span></a>
		</div>
	</div>
<?= Form::close(); ?>
