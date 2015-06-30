<div class="form-group">
	<?= Form::label('alterar-configuracao-sintetizador', 'Sintetizador:', array('class' => 'control-label col-md-4')) ?>
	<div class="col-md-8">
		<?= Form::select('configuracoes[SINTETIZADOR][valor]', array('' => 'nenhum') + $form_preferencias['lista_sintetizadores'], $form_preferencias['dados']['configuracoes']['SINTETIZADOR']['valor'], array('id' => 'alterar-configuracao-sintetizador', 'class' => 'form-control', 'required' => 'required')) ?>
	</div>
</div>