<?php
/**
 * Model Secao_Imagem
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Secao_Imagem extends ORM {
	protected $_table_name = 'secoes_imagens';
	protected $_primary_key = 'id_secao_imagem';

	protected $_table_columns = array(
		'id_secao_imagem' => NULL,
		'posicao' => NULL,
		'id_secao' => NULL,
		'id_imagem' => NULL,
	);

	protected $_belongs_to = array(
		'imagem' => array('model' => 'Imagem', 'foreign_key' => 'id_imagem'),
		'secao' => array('model' => 'Secao', 'foreign_key' => 'id_secao'),
	);

	public function rules()
	{
		return array(
			'posicao' => array(
				array('not_empty')
			),
			'id_secao' => array(
				array('not_empty')
			),
			'id_imagem' => array(
				array('not_empty')
			),
		);
	}
}