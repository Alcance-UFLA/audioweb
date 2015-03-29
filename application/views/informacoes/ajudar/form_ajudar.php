<?= Helper_Mensagens::exibir($mensagens) ?>
<?php HTML::start_block() ?>
<div class="well">
	<?= HTML::start_header(array('class' => 'h4 text-center margem-inferior')) ?>
		<i class="glyphicon glyphicon-envelope"></i> Formulário para Comentários sobre o AudioWeb
	<?= HTML::end_header() ?>
	<form id="formulario-contato" class="form-horizontal" method="post" action="<?= Route::url('acao_padrao', array('directory' => 'informacoes', 'controller' => 'ajudar', 'action' => 'mensagem')) ?>">
		<div class="form-group">
			<label for="ajudar-nome" class="col-sm-2 control-label">Nome:</label>
			<div class="col-sm-10">
				<?= Form::input('nome', Arr::get($form_ajudar['dados'], 'nome'), array('type' => 'text', 'id' => 'ajudar-nome', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Seu nome', 'autocomplete' => 'off')) ?>
			</div>
		</div>
		<div class="form-group">
			<label for="ajudar-email" class="col-sm-2 control-label">E-mail:</label>
			<div class="col-sm-10">
				<?= Form::input('email', Arr::get($form_ajudar['dados'], 'email'), array('type' => 'email', 'id' => 'ajudar-email', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Seu e-mail', 'autocomplete' => 'off')) ?>
			</div>
		</div>
		<div class="form-group">
			<label for="ajudar-texto" class="col-sm-2 control-label">Mensagem:</label>
			<div class="col-sm-10">
				<?= Form::textarea('texto', Arr::get($form_ajudar['dados'], 'texto'), array('rows' => 5, 'cols' => 50, 'id' => 'ajudar-texto', 'class' => 'form-control', 'required' => 'required', 'placeholder' => 'Sua mensagem com comentários e/ou sugestões sobre o AudioWeb.', 'autocomplete' => 'off')) ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-lg btn-primary"><i class="glyphicon glyphicon-envelope"></i> Enviar Mensagem</button>
			</div>
		</div>
	</form>
</div>
<?php HTML::end_block() ?>