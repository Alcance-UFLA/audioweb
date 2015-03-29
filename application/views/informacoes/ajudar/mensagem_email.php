<div style="max-width: 500px; border: 1px solid #CCCCCC; padding: 10px; margin: 0 auto; font-family: Arial, verdana, sans-serif; border-radius: 10px;">
	<p>Uma nova mensagem foi enviada pela p&aacute;gina do AudioWeb:</p>

	<p><b>Nome:</b> <?= HTML::chars($nome) ?></p>
	<p><b>E-mail:</b> <?= HTML::chars($email) ?></p>
	<p><b>Mensagem:</b></p>

	<blockquote style="border-left: 4px solid #EEEEEE; margin-left: 10px; padding: 10px 20px; font-style: italic; color: #808080;">
		<?= nl2br(HTML::chars($texto)) ?>
	</blockquote>

	<hr />
	<p><a href="<?= Route::url('default') ?>">AudioWeb</a></p>
</div>