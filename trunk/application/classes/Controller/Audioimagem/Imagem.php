<?php
/**
 * Action para exibir imagens gravadas.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Controller_Audioimagem_Imagem extends Controller_Geral {

	/**
	 * Action para exibir uma imagem gravada.
	 * @return void
	 */
	public function action_index()
	{
		$this->requerer_autenticacao(false);
		$id_conta   = $this->request->param('conta');
		$nome       = $this->request->param('nome');
		$tamanho    = $this->request->param('tamanho');

		$imagem = ORM::factory('Imagem')
			->join(ORM::factory('Usuario')->table_name(), 'INNER')
			->on('imagem.id_usuario', '=', 'usuarios.id_usuario')
			->where('usuarios.id_conta', '=', $id_conta)
			->and_where('imagem.arquivo', '=', $nome)
			->find();

		if ( ! $imagem->loaded())
		{
			throw HTTP_Exception::factory(404, 'Imagem não encontrada');
		}

		$conteudo = Model_Util_Armazenamento_Arquivo::obter($imagem->pk());

		// Realizar redimensionamento
		if ($tamanho != '0x0')
		{
			$pos = strpos($tamanho, 'x');
			$largura = (int)substr($tamanho, 0, $pos);
			$altura = (int)substr($tamanho, $pos + 1);

			$largura = $largura ? $largura : null;
			$altura  = $altura  ? $altura  : null;

			$arq_temp = tempnam(Kohana::$cache_dir, 'img-resize');
			file_put_contents($arq_temp, $conteudo);
			$conteudo = '';

			$image_manipulation = Image::factory($arq_temp);
			$image_manipulation->resize($largura, $altura);
			$conteudo = $image_manipulation->render();
			unset($image_manipularion);
			unlink($arq_temp);
		}

		$encoding = Http_Header::parse_encoding_header($this->request->headers('accept-encoding'));

		$compressao = null;
		if (isset($encoding['gzip']) && $encoding['gzip'])
		{
			$conteudo = gzencode($conteudo, 9, FORCE_GZIP);
			$this->response->headers('Content-Encoding', 'gzip');
		}
		elseif (isset($encoding['deflate']) && $encoding['deflate'])
		{
			$conteudo = gzencode($conteudo, 9, FORCE_DEFLATE);
			$this->response->headers('Content-Encoding', 'deflate');
		}

		$this->etag = sha1($conteudo);
		$this->response->headers('Content-Type', $imagem->mime_type);
		$this->response->headers('Cache-Control', 'private');
		$this->response->headers('Content-Length', strlen($conteudo));
		$this->response->headers('Last-Modified', gmdate('D, d M Y H:i:s T', strtotime($imagem->data_alteracao)));
		$this->response->headers('Expires', gmdate('D, d M Y H:i:s T', strtotime('+1minute')));
		$this->response->body($conteudo);
	}
}