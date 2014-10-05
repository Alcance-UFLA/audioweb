<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<h1><i class="glyphicon glyphicon-tag"></i> Mapear imagem <small><?= HTML::chars($form_imagem['dados']['imagem']['nome']) ?></small></h1>
	</header>

	<nav>
		<span class="sr-only">Navegação:</span>
		<ol class="breadcrumb">
			<li><a href="<?= Route::url('principal') ?>">Início</a></li>
			<li><a href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>">AudioImagem</a></li>
			<li class="active">Mapear Imagem</li>
		</ol>
	</nav>

	<?= Helper_Mensagens::exibir($mensagens) ?>

	<div class="row">
		<div class="col-md-4">
			<?= View::factory('audioimagem/mapear/lista_regioes')->set('form_imagem', $form_imagem) ?>
		</div>
		<div class="col-md-8">
			<div class="panel panel-default">
				<img id="imagem" class="img-responsive" alt="<?= HTML::chars($form_imagem['dados']['imagem']['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $form_imagem['dados']['imagem']['id_conta'], 'nome' => $form_imagem['dados']['imagem']['arquivo'])) ?>" width="<?= $form_imagem['dados']['imagem']['largura'] ?>" height="<?= $form_imagem['dados']['imagem']['altura'] ?>" data-largura-original="<?= $form_imagem['dados']['imagem']['largura'] ?>" data-altura-original="<?= $form_imagem['dados']['imagem']['altura'] ?>" />
			</div>

			<div class="area-acoes well">
				<p class="tipo-regiao">
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
				<p class="acoes">
					Ações:
					&nbsp;
					<button class="btn btn-warning btn-voltar-ponto" type="button"><i class="glyphicon glyphicon-step-backward"></i> Voltar ponto</button>
					&nbsp;
					<button class="btn btn-danger btn-limpar-regiao" type="button"><i class="glyphicon glyphicon-trash"></i> Limpar região</button>
					&nbsp;
					<button class="btn btn-success btn-salvar" type="button" data-toggle="modal" data-target="#modal-form-regiao"><i class="glyphicon glyphicon-ok"></i> Salvar</button>
				</p>
			</div>

			<?= View::factory('audioimagem/mapear/form_regiao')->set('form_imagem', $form_imagem)->set('mensagens', $mensagens) ?>
		</div>
	</div>
</section>