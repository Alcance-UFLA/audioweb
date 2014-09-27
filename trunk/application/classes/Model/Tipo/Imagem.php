<?php
/**
 * Model Tipo_Imagem
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Tipo_Imagem extends ORM {

	protected $_table_name = 'tipos_imagens';
	protected $_primary_key = 'id_tipo_imagem';

	protected $_table_columns = array(
		'id_tipo_imagem' => NULL,
		'nome' => NULL,
	);

	public function rules()
	{
		return array(
			'id_tipo_imagem' => array(
				array('not_empty')
			),
			'nome' => array(
				array('not_empty')
			),
		);
	}
}