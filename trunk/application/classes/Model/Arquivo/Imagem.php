<?php
/**
 * Arquivo da Imagem
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Arquivo_Imagem extends ORM {

	protected $_table_name = 'arquivos_imagens';
	protected $_primary_key = 'id_arquivo_imagem';

	protected $_table_columns = array(
		'id_arquivo_imagem' => NULL,
		'conteudo' => NULL,
		'id_imagem' => NULL
	);

	public function rules()
	{
		return array(
			'conteudo' => array(
				array('not_empty')
			),
			'id_imagem' => array(
				array('not_empty'),
			),
		);
	}

}
