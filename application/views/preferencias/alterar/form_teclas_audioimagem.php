<?php foreach ($form_preferencias['dados']['teclas'] as $chave => $dados_tecla): ?>
<div class="form-group">
	<?= Form::label('alterar-tecla-' . $chave, $dados_tecla['acao'] . ':', array('class' => 'control-label col-md-5')) ?>
	<div class="col-md-2">
		<?= Form::select('teclas[' . $chave . '][codigo]', $form_preferencias['lista_teclas'], strval($form_preferencias['dados']['teclas'][$chave]['codigo']), array('id' => 'alterar-tecla-' . $chave, 'class' => 'form-control', 'required' => 'required')) ?>
	</div>
	<div class="col-md-5">
		<div class="checkbox">
			<label class="checkbox-inline">
				<?= Form::hidden('teclas[' . $chave . '][shift]', '0') ?>
				<?= Form::checkbox('teclas[' . $chave . '][shift]', '1', (bool)$form_preferencias['dados']['teclas'][$chave]['shift']) ?>
				Shift
			</label>
			<label class="checkbox-inline">
				<?= Form::hidden('teclas[' . $chave . '][alt]', '0') ?>
				<?= Form::checkbox('teclas[' . $chave . '][alt]', '1', (bool)$form_preferencias['dados']['teclas'][$chave]['alt']) ?>
				Alt
			</label>
			<label class="checkbox-inline">
				<?= Form::hidden('teclas[' . $chave . '][ctrl]', '0') ?>
				<?= Form::checkbox('teclas[' . $chave . '][ctrl]', '1', (bool)$form_preferencias['dados']['teclas'][$chave]['ctrl']) ?>
				Ctrl
			</label>
		</div>
	</div>
</div>
<hr />
<?php endforeach ?>