<div id="modal-form-regiao" class="modal fade" role="dialog" aria-hidden="true" aria-labeledby="#titulo-form-regiao">
	<div class="modal-dialog">
		<div class="modal-content">
			<?= Form::open('audioimagem/mapear/' . $form_imagem['dados']['imagem']['id_imagem'] . '/salvar/', array('id' => 'form-mapear', 'class' => 'form-horizontal')) ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
					<h4 id="titulo-form-regiao" class="modal-title"><i class="glyphicon glyphicon-tag"></i> Inserir Região</h4>
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
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i> Salvar Região</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			<?= Form::close() ?>
		</div>
	</div>
</div>