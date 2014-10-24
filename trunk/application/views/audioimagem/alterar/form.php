<?= Form::open('audioimagem/alterar/' . $form_imagem['dados']['id_imagem'] . '/salvar/', array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) ?>
	<div class="form-group">
		<?= Form::label('alterar-arquivo', 'Arquivo:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::hidden('MAX_FILE_SIZE', Num::bytes($form_imagem['tamanho_limite_upload'])) ?>
			<?= Form::file('arquivo', array('id' => 'alterar-arquivo', 'accept' => 'image/*', 'autofocus' => 'autofocus')) ?>
			<p class="help-block">Envie um arquivo de imagem com tamanho máximo <?= HTML::chars($form_imagem['tamanho_limite_upload']) ?>, ou deixe o campo vazio para manter a mesma imagem.</p>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-nome', 'Nome:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('nome', Arr::get($form_imagem['dados'], 'nome'), array('id' => 'alterar-nome', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Nome breve')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-descricao', 'Descrição:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::textarea('descricao', Arr::get($form_imagem['dados'], 'descricao'), array('id' => 'alterar-descricao', 'class' => 'form-control', 'cols' => '50', 'rows' => '4', 'required' => 'required', 'placeholder' => 'Descrição longa')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-id-tipo-imagem', 'Tipo:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::select('id_tipo_imagem', array('' => 'Escolha') + $form_imagem['lista_id_tipo_imagem'], Arr::get($form_imagem['dados'], 'id_tipo_imagem'), array('id' => 'alterar-id-tipo-imagem', 'class' => 'form-control', 'required' => 'required')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-rotulos', 'Rótulos:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?= Form::input('rotulos', Arr::get($form_imagem['dados'], 'rotulos'), array('id' => 'alterar-rotulos', 'class' => 'form-control', 'maxlength' => '256', 'placeholder' => 'Rótulos separados por vírgula')) ?>
		</div>
	</div>
	<div class="form-group">
		<?= Form::label('alterar-publico-alvo', 'Público Álvo:', array('class' => 'control-label col-md-4')) ?>
		<div class="col-md-8">
			<?php foreach ($form_imagem['lista_id_publico_alvo'] as $id_publico_alvo => $nome_publico_alvo): ?>
			<div class="checkbox">
				<label>
					<?= Form::checkbox('publico_alvo[]', $id_publico_alvo, in_array($id_publico_alvo, Arr::get($form_imagem['dados'], 'publico_alvo', array())), array('id' => 'alterar-publico-alvo-' . $id_publico_alvo)) ?>
					<span><?= HTML::chars($nome_publico_alvo) ?></span>
				</label>
			</div>
			<?php endforeach ?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-pencil"></i> Alterar', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>">Cancelar</a>
		</div>
	</div>
<?= Form::close(); ?>