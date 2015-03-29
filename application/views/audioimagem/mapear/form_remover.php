<?php HTML::start_block() ?>
<article id="modal-form-remover" class="modal fade" data-abrir="<?= ($form_imagem['dados']['acao'] == 'remover') ? '1' : '0' ?>" role="dialog" aria-hidden="true" aria-labeledby="#titulo-form-remover">
	<div class="modal-dialog">
		<div class="modal-content">
			<?= Form::open(Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $form_imagem['dados']['imagem']['id_imagem'], 'action' => 'regiao', 'opcao1' => 'remover', 'opcao2' => $form_imagem['dados']['regiao']['id_imagem_regiao'], 'opcao3' => 'salvar')), array('id' => 'form-remover', 'class' => 'form-horizontal')) ?>
				<header class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
					<?= HTML::start_header(array('id' => 'titulo-form-remover', 'class' => 'modal-title h4')) ?>
						<i class="glyphicon glyphicon-tag"></i> <span class="texto-titulo-form-regiao">Remover Região</span>
					<?= HTML::end_header() ?>
				</header>
				<div class="modal-body">
					<?= Helper_Mensagens::exibir($mensagens) ?>
					<div class="form-group">
						<?= Form::label('remover-nome', 'Nome:', array('class' => 'control-label col-md-4')) ?>
						<div class="col-md-8">
							<p class="form-control-static"><?= HTML::chars($form_imagem['dados']['regiao']['nome'])?></p>
						</div>
					</div>
					<div class="form-group">
						<?= Form::label('remover-descricao', 'Descrição:', array('class' => 'control-label col-md-4')) ?>
						<div class="col-md-8">
							<p class="form-control-static"><?= HTML::chars($form_imagem['dados']['regiao']['descricao'])?></p>
						</div>
					</div>
					<div class="form-group">
						<?= Form::label('remover-tipo-regiao', 'Tipo de Região:', array('class' => 'control-label col-md-4')) ?>
						<div class="col-md-8">
							<p class="form-control-static"><?= HTML::chars($form_imagem['lista_tipo_regiao'][$form_imagem['dados']['regiao']['tipo_regiao']]) ?></p>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-8 col-md-offset-4">
							<div class="checkbox">
								<label>
									<?= Form::checkbox('confirmar', '1', false, array('id' => 'remover-confirmar')) ?>
									<span>Confirmar remoção desta região</span>
								</label>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<footer class="modal-footer">
					<button type="submit" class="btn btn-danger btn-remover-regiao"><i class="glyphicon glyphicon-trash"></i> Remover Região</button>
					&nbsp;
					<a class="btn btn-default btn-cancelar-remocao" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $form_imagem['dados']['imagem']['id_imagem'])) ?>"><i class="glyphicon glyphicon-remove"></i> Cancelar Remoção</a>
				</footer>
			<?= Form::close() ?>
		</div>
	</div>
</article>
<?php HTML::end_block() ?>