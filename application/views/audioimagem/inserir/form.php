<?= Form::open(Route::url('acao_padrao', array('directory' => 'audioimagem', 'controller' => 'inserir', 'action' => 'salvar')), array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) ?>
	<div class="form-group">
		<?= Form::label('inserir-arquivo', 'Arquivo:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::hidden('MAX_FILE_SIZE', Num::bytes($form_imagem['tamanho_limite_upload'])) ?>
			<?= Form::file('arquivo', array('id' => 'inserir-arquivo', 'required' => 'required', 'accept' => 'image/*')) ?>
			<p class="help-block">Envie um arquivo de imagem com tamanho máximo <?= HTML::chars($form_imagem['tamanho_limite_upload']) ?>.</p>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-nome', 'Nome (descrição curta):', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('nome', Arr::get($form_imagem['dados'], 'nome'), array('id' => 'inserir-nome', 'class' => 'form-control', 'maxlength' => '64', 'required' => 'required', 'placeholder' => 'Nome breve')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-descricao', 'Descrição longa:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::textarea('descricao', Arr::get($form_imagem['dados'], 'descricao'), array('id' => 'inserir-descricao', 'class' => 'form-control', 'cols' => '50', 'rows' => '4', 'required' => 'required', 'placeholder' => 'Descrição longa')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-id-tipo-imagem', 'Tipo:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::select('id_tipo_imagem', array('' => 'Escolha') + $form_imagem['lista_id_tipo_imagem'], Arr::get($form_imagem['dados'], 'id_tipo_imagem'), array('id' => 'inserir-id-tipo-imagem', 'class' => 'form-control', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-rotulos', 'Rótulos:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('rotulos', Arr::get($form_imagem['dados'], 'rotulos'), array('id' => 'inserir-rotulos', 'class' => 'form-control', 'maxlength' => '256', 'placeholder' => 'Rótulos separados por vírgula')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('inserir-publico-alvo', 'Público Álvo:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8 text-columns-md">
			<?php foreach ($form_imagem['lista_id_publico_alvo'] as $id_publico_alvo => $nome_publico_alvo): ?>
			<div class="checkbox">
				<label>
					<?= Form::checkbox('publico_alvo[]', $id_publico_alvo, in_array($id_publico_alvo, Arr::get($form_imagem['dados'], 'publico_alvo', array())), array('id' => 'inserir-publico-alvo-' . $id_publico_alvo)) ?>
					<span><?= HTML::chars($nome_publico_alvo) ?></span>
				</label>
			</div>
			<?php endforeach ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-plus"></i> Inserir <span class="sr-only">nova imagem</span>', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a lista de imagens</span></a>
		</div>
	</div>
<?= Form::close(); ?>
