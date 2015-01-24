<div style="max-width: 500px; border: 1px solid #CCCCCC; padding: 10px; margin: 0 auto; font-family: Arial, verdana, sans-serif;">
	<p>Ol&aacute;, <?= HTML::chars($acesso_especial['usuario']['nome']) ?></p>

	<p>Recebemos um pedido para recuperar seu acesso ao sistema AudioWeb.</p>

	<p>
		Caso tenha feito este pedido, acesse o link abaixo e defina uma nova senha:<br />
		<a href="<?= Route::url('acao_padrao', array('directory' => 'autenticacao', 'controller' => 'autenticar', 'action' => 'especial', 'opcao1' => $acesso_especial['hash'])) ?>">Recuperar acesso ao AudioWeb</a>
	</p>

	<p>Este link ficar&aacute; dispon&iacute;vel at&eacute; <?= strftime('%d/%m/%Y %H:%M', strtotime($acesso_especial['validade'])) ?> e s&oacute; poder&aacute; ser usado uma vez.</p>

	<p>Caso n&atilde;o tenha feito este pedido, ignore esta mensagem.</p>

	<hr />
	<p><a href="<?= Route::url('default') ?>">AudioWeb</a></p>
</div>