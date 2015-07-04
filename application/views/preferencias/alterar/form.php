<?= Form::open(Route::url('acao_padrao', array('directory' => 'preferencias', 'controller' => 'alterar', 'action' => 'salvar')), array('class' => 'form-horizontal')) ?>
	<div>
		<ul class="nav nav-tabs margem-inferior" role="tablist">
			<li role="presentation" class="active"><a href="#aba-usuario" aria-controls="aba-usuario" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Dados de Usuário</a></li>
			<li role="presentation"><a href="#aba-senha" aria-controls="aba-senha" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-lock"></i> Senha</a></li>
			<li role="presentation"><a href="#aba-teclas" aria-controls="aba-teclas" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-hand-up"></i> Teclas do AudioImagem</a></li>
			<li role="presentation"><a href="#aba-configuracoes" aria-controls="aba-configuracoes" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-wrench"></i> Configurações</a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="aba-usuario">
				<?= View::factory('preferencias/alterar/form_usuario')->set('form_preferencias', $form_preferencias) ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="aba-senha">
				<?= View::factory('preferencias/alterar/form_senha')->set('form_preferencias', $form_preferencias) ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="aba-teclas">
				<?= View::factory('preferencias/alterar/form_teclas_audioimagem')->set('form_preferencias', $form_preferencias) ?>
			</div>
			<div role="tabpanel" class="tab-pane" id="aba-configuracoes">
				<?= View::factory('preferencias/alterar/form_configuracoes')->set('form_preferencias', $form_preferencias) ?>
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-offset-4 col-md-8">
			<?= Form::button('submit', '<i class="glyphicon glyphicon-pencil"></i> Alterar <span class="sr-only">preferências</span>', array('class' => 'btn btn-success btn-lg')) ?>
			&nbsp;
			<a class="btn btn-default btn-lg" href="<?= Route::url('principal') ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para a página inicial</span></a>
		</div>
	</div>
<?= Form::close(); ?>
