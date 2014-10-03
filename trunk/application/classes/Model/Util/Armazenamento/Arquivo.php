<?php
/**
 * Classe responsavel por encapsular o armazenamento dos arquivos de imagem
 * para que possam ser salvos tanto em Banco quanto em Arquivos.
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Util_Armazenamento_Arquivo {
	/**
	 * Armazena um arquivo de imagem
	 * @param int $id_imagem
	 * @param string $conteudo
	 * @return void
	 */
	public static function salvar($id_imagem, $conteudo)
	{
		$arquivo = ORM::Factory('Arquivo_Imagem')->where('id_imagem', '=', $id_imagem)->find();
		$arquivo->id_imagem = $id_imagem;
		$arquivo->conteudo  = $conteudo;
		$arquivo->save();
	}

	/**
	 * Obtem o conteudo de um arquivo de imagem a partir de seu ID.
	 * @param int $id_imagem
	 * @return string
	 */
	public static function obter($id_imagem)
	{
		$arquivo = ORM::Factory('Arquivo_Imagem')
			->where('id_imagem', '=', $id_imagem)
			->find();
		if ( ! $arquivo->loaded())
		{
			throw new RuntimeException('Arquivo nao encontrado');
		}
		return $arquivo->conteudo;
	}

}