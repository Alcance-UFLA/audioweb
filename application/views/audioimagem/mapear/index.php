<?php HTML::start_block() ?>
<section id="conteudo-principal" class="container" role="main">
	<header class="page-header">
		<?= HTML::start_header() ?>
			<i class="glyphicon glyphicon-tag"></i> Mapear imagem <small><?= HTML::chars($form_imagem['dados']['imagem']['nome']) ?></small>
		<?= HTML::end_header() ?>
	</header>
	<?= Helper_Trilha::exibir($trilha) ?>
	<?= Helper_Mensagens::exibir($mensagens) ?>
	<div class="row">
		<div class="col-md-4">
			<?= View::factory('audioimagem/mapear/area_acoes')->set('form_imagem', $form_imagem) ?>
			<?= View::factory('audioimagem/mapear/lista_regioes')->set('form_imagem', $form_imagem) ?>
		</div>
		<div class="col-md-8">
			<?php HTML::start_block() ?>
			<article class="panel panel-default">
				<header>
					<?= HTML::header('Imagem para mapeamento', array('class' => 'sr-only')) ?>
				</header>
				<img id="imagem" class="img-responsive" alt="<?= HTML::chars($form_imagem['dados']['imagem']['nome']) ?>" src="<?= Route::url('exibir_imagem', array('conta' => $form_imagem['dados']['imagem']['id_conta'], 'nome' => $form_imagem['dados']['imagem']['arquivo'])) ?>" width="<?= $form_imagem['dados']['imagem']['largura'] ?>" height="<?= $form_imagem['dados']['imagem']['altura'] ?>" data-largura-original="<?= $form_imagem['dados']['imagem']['largura'] ?>" data-altura-original="<?= $form_imagem['dados']['imagem']['altura'] ?>" />
			</article>
			<?php HTML::end_block() ?>

			<?= View::factory('audioimagem/mapear/form_regiao')->set('form_imagem', $form_imagem)->set('mensagens', $mensagens) ?>
			<?php if ($form_imagem['dados']['acao'] == 'remover'): ?>
			<?= View::factory('audioimagem/mapear/form_remover')->set('form_imagem', $form_imagem)->set('mensagens', $mensagens) ?>
			<?php endif ?>
		</div>
	</div>
	<footer id="area-botoes" class="well">
		<a class="btn btn-lg btn-default" href="<?= Route::url('listar', array('directory' => 'audioimagem')) ?>"><i class="glyphicon glyphicon-chevron-left"></i> Voltar <span class="sr-only">para lista de imagens</span></a>
		<span class="sr-only">,</span>
		<a class="btn btn-lg btn-default" href="<?= Route::url('alterar', array('directory' => 'audioimagem', 'controller' => 'exibir', 'action' => 'index', 'id' => $form_imagem['dados']['imagem']['id_imagem']))?>"><i class="glyphicon glyphicon-eye-open"></i> Exibir imagem</a>
	</footer>
</section>
<?php HTML::end_block() ?>