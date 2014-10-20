<?php
if ($form_imagem['dados']['regiao']['id_imagem_regiao']) {
	$opcao1 = 'alterar';
	$opcao2 = $form_imagem['dados']['regiao']['id_imagem_regiao'];
	$opcao3 = 'salvar';
	$titulo_formulario = 'Alterar Região';
} else {
	$opcao1 = 'inserir';
	$opcao2 = 'salvar';
	$opcao3 = '';
	$titulo_formulario = 'Inserir Região';
}
switch ($form_imagem['dados']['acao']) {
	case 'inserir':
		$abrir_modal = '1';
	break;
	case 'alterar':
		$abrir_modal = $mensagens ? '1' : '0';
	break;
	default:
		$abrir_modal = '0';
	break;
}
?>
<div id="modal-form-regiao" class="modal fade" data-abrir="<?= $abrir_modal ?>" role="dialog" aria-hidden="true" aria-labeledby="#titulo-form-regiao">
	<div class="modal-dialog">
		<div class="modal-content">
			<?= Form::open(Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $form_imagem['dados']['imagem']['id_imagem'], 'action' => 'regiao', 'opcao1' => $opcao1, 'opcao2' => $opcao2, 'opcao3' => $opcao3)), array('id' => 'form-mapear', 'class' => 'form-horizontal')) ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
					<h2 id="titulo-form-regiao" class="modal-title h4"><i class="glyphicon glyphicon-tag"></i> <span class="texto-titulo-form-regiao"><?= $titulo_formulario ?></span></h2>
				</div>
				<div class="modal-body">
					<?= Helper_Mensagens::exibir($mensagens) ?>
					<div class="form-group">
						<?= Form::label('regiao-nome', 'Nome:', array('class' => 'control-label col-md-4')) ?>
						<div class="col-md-8">
							<?= Form::input('nome', Arr::get($form_imagem['dados']['regiao'], 'nome'), array('id' => 'regiao-nome', 'class' => 'form-control', 'maxlength' => '128', 'required' => 'required', 'placeholder' => 'Nome breve da região')) ?>
						</div>
					</div>
					<div class="form-group">
						<?= Form::label('regiao-descricao', 'Descrição:', array('class' => 'control-label col-md-4')) ?>
						<div class="col-md-8">
							<?= Form::textarea('descricao', Arr::get($form_imagem['dados']['regiao'], 'descricao'), array('id' => 'regiao-descricao', 'class' => 'form-control', 'cols' => '50', 'rows' => '4', 'required' => 'required', 'placeholder' => 'Descrição longa da região')) ?>
						</div>
					</div>
					<div class="form-group">
						<?= Form::label('regiao-tipo-regiao', 'Tipo de Região:', array('class' => 'control-label col-md-4')) ?>
						<div class="col-md-8">
							<?= Form::select('tipo_regiao', $form_imagem['lista_tipo_regiao'], Arr::get($form_imagem['dados']['regiao'], 'tipo_regiao'), array('id' => 'regiao-tipo-regiao', 'class' => 'form-control', 'required' => 'required')) ?>
						</div>
					</div>
					<div class="form-group">
						<?= Form::label('regiao-coordenadas', 'Coordenadas:', array('class' => 'control-label col-md-4')) ?>
						<div class="col-md-8">
							<?= Form::textarea('coordenadas', Arr::get($form_imagem['dados']['regiao'], 'coordenadas'), array('id' => 'regiao-coordenadas', 'class' => 'form-control', 'cols' => '50', 'rows' => '2', 'required' => 'required', 'placeholder' => 'Coordenadas da região')) ?>
							<span class="help-block">Para alterar as coordenadas, feche este formulário, use a ferramenta de mapeamento da imagem e depois clique em "Salvar região" novamente.</span>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success btn-salvar-dados-regiao"><i class="glyphicon glyphicon-ok"></i> Salvar Região</button>
					&nbsp;
					<button type="button" class="btn btn-default btn-fechar-modal-regiao" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Cancelar</button>
				</div>
			<?= Form::close() ?>
		</div>
	</div>
</div>