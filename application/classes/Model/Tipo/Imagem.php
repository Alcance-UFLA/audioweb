<?php
/**
 * Model Tipo_Imagem
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Tipo_Imagem extends Model_Base {
	protected $_table_name = 'tipos_imagens';
	protected $_primary_key = 'id_tipo_imagem';

	protected $_table_columns = array(
		'id_tipo_imagem' => NULL,
		'nome' => NULL,
	);

	protected $_has_many = array(
		'imagens' => array('model' => 'Imagem', 'foreign_key' => 'id_tipo_imagem', 'far_key' => 'id_imagem')
	);

	public function rules()
	{
		return array(
			'nome' => array(
				array('not_empty')
			),
		);
	}
}