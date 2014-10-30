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
<article class="panel panel-primary area-acoes">
	<header class="panel-heading">
		<h2 class="panel-title"><i class="glyphicon glyphicon-cog"></i> Opções para mapeamento</h2>
	</header>
	<div class="panel-body">
		<div class="tipo-regiao form-group">
			<label for="lista-tipos-regioes">Tipo de Região:</label>
			<div id="lista-tipos-regioes" data-toggle="buttons" class="btn-group">
				<?php foreach ($form_imagem['lista_tipo_regiao'] as $id_tipo_regiao => $nome_tipo_regiao): ?>
				<label class="btn btn-default btn-<?= $id_tipo_regiao?> <?= $form_imagem['dados']['regiao']['tipo_regiao'] == $id_tipo_regiao ? 'active' : '' ?>">
					<?= Form::radio('btn_tipo_regiao', $id_tipo_regiao, $form_imagem['dados']['regiao']['tipo_regiao'] == $id_tipo_regiao) ?>
					<?php if ($id_tipo_regiao == 'poly'): ?>
					<i class="glyphicon glyphicon-poligono"></i>
					<?php elseif ($id_tipo_regiao == 'rect'): ?>
					<i class="glyphicon glyphicon-retangulo"></i>
					<?php elseif ($id_tipo_regiao == 'circle'): ?>
					<i class="glyphicon glyphicon-circulo"></i>
					<?php endif ?>
					<?= HTML::chars($nome_tipo_regiao) ?>
				</label>
				<?php endforeach ?>
			</div>
		</div>
		<div class="cor form-group">
			<label for="cor-selecao">Cor de Seleção:</label>
			<div><input type="color" id="cor-selecao" name="cor_selecao" value="#FF0000" size="10" maxlength="7" data-cookie-path="<?= HTML::chars($cookie_cor_selecao['path']) ?>" data-cookie-domain="<?= HTML::chars($cookie_cor_selecao['domain']) ?>" data-cookie-expires="<?= HTML::chars($cookie_cor_selecao['expires']) ?>" /></div>
		</div>
		<div class="acoes form-group">
			<label for="lista-acoes">Ações:</label>
			<div id="lista-acoes">
				<button class="btn btn-warning btn-block btn-voltar-ponto" type="button"><i class="glyphicon glyphicon-step-backward"></i> Voltar ponto</button>
				<button class="btn btn-danger btn-block btn-limpar-regiao" type="button"><i class="glyphicon glyphicon-trash"></i> Limpar região</button>
				<button class="btn btn-success btn-block btn-salvar-regiao" type="button" data-toggle="modal" data-target="#modal-form-regiao"><i class="glyphicon glyphicon-ok"></i> Salvar região</button>
				<?php if ($form_imagem['dados']['regiao']['id_imagem_regiao']): ?>
				<a class="btn btn-default btn-block btn-cancelar-alteracao" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'mapear', 'id' => $form_imagem['dados']['imagem']['id_imagem'])) ?>"><i class="glyphicon glyphicon-remove"></i> Cancelar Alteração</a>
				<?php endif ?>
			</div>
		</div>
	</div>
</article>