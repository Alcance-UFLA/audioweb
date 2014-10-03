<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<caption>Lista de imagens</caption>
		<thead>
			<tr>
				<th id="coluna-miniatura" scope="col">Miniatura</th>
				<th id="coluna-nome" scope="col">Nome</th>
				<th id="coluna-data-criacao" scope="col">Data de Criação</th>
				<th id="coluna-opcoes" scope="col">Opções</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($imagens['lista'] as $imagem): ?>
			<tr>
				<td headers="coluna-miniatura"><img src="<?= Route::url('exibir_imagem', array('conta' => $imagem['id_conta'], 'nome' => $imagem['arquivo'], 'tamanho' => '50x50')) ?>" alt="<?= HTML::chars($imagem['nome']) ?>" /></td>
				<td headers="coluna-nome"><?= HTML::chars($imagem['nome']) ?></td>
				<td headers="coluna-data-criacao"><time datetime="<?= HTML::chars(Date::formatted_time($imagem['data_cadastro'], 'Y-m-d H:i:s')) ?>"><?= HTML::chars(Date::formatted_time($imagem['data_cadastro'], 'd/m/Y - H:i:s')) ?></time></td>
				<td headers="coluna-opcoes">
					<div class="btn-group">
						<?= HTML::anchor('audioimagem/alterar/'.$imagem['id_imagem'], '<i class="glyphicon glyphicon-pencil"></i> <span>Alterar <span class="sr-only">Imagem ' . HTML::chars($imagem['nome']) . '</span></span>', array('class' => 'btn btn-default btn-sm btn-alterar')) ?>
						<?= HTML::anchor('audioimagem/mapear/'.$imagem['id_imagem'], '<i class="glyphicon glyphicon-tag"></i> <span>Mapear <span class="sr-only">Imagem ' . HTML::chars($imagem['nome']) . '</span></span>', array('class' => 'btn btn-default btn-sm btn-mapear')) ?>
					</div>
				</td>
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>
</div>