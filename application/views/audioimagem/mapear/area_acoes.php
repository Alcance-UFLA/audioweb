<?php
$dados_url = parse_url(Route::url('default'));
$cookie_cor_selecao = array();
$cookie_cor_selecao['path'] = rtrim($dados_url['path'], '/') . '/audioimagem/mapear/';
if (isset($dados_url['host'])) {
	$cookie_cor_selecao['domain'] = $dados_url['host'];
} else {
	$cookie_cor_selecao['domain'] = $_SERVER['HTTP_HOST'];
}
$cookie_cor_selecao['expires'] = 30;
?>
<div class="area-acoes well">
	<ul class="list-inline">
		<li class="tipo-regiao">
			<p>
				Tipo de Região:
				&nbsp;
				<span data-toggle="buttons" class="btn-group">
					<label class="btn btn-default btn-poly">
						<input type="radio" value="poly" name="btn_tipo_regiao"> Polígono
					</label>
					<label class="btn btn-default btn-rect">
						<input type="radio" value="rect" name="btn_tipo_regiao"> Retângulo
					</label>
					<label class="btn btn-default btn-circle">
						<input type="radio" value="circle" name="btn_tipo_regiao"> Círculo
					</label>
				</span>
			</p>
		</li>
		<li class="cor">
			<p>
				Cor de Seleção:
				&nbsp;
				<input type="color" id="cor-selecao" name="cor_selecao" value="#FF0000" size="10" maxlength="7" data-cookie-path="<?= HTML::chars($cookie_cor_selecao['path']) ?>" data-cookie-domain="<?= HTML::chars($cookie_cor_selecao['domain']) ?>" data-cookie-expires="<?= HTML::chars($cookie_cor_selecao['expires']) ?>" />
			</p>
		</li>
		<li class="acoes">
			<p>
				Ações:
				&nbsp;
				<button class="btn btn-warning btn-voltar-ponto" type="button"><i class="glyphicon glyphicon-step-backward"></i> Voltar ponto</button>
				&nbsp;
				<button class="btn btn-danger btn-limpar-regiao" type="button"><i class="glyphicon glyphicon-trash"></i> Limpar região</button>
				&nbsp;
				<button class="btn btn-success btn-salvar-regiao" type="button" data-toggle="modal" data-target="#modal-form-regiao"><i class="glyphicon glyphicon-ok"></i> Salvar região</button>
				<?php if ($form_imagem['dados']['regiao']['id_imagem_regiao']): ?>
				&nbsp;
				<a class="btn btn-default btn-cancelar-alteracao" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $form_imagem['dados']['imagem']['id_imagem'])) ?>"><i class="glyphicon glyphicon-remove"></i> Cancelar Alteração</a>
				<?php endif ?>
			</p>
		</li>
	</ul>
</div>