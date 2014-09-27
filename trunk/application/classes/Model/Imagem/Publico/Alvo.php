<?php
/**
 * Model Imagem_Publico_Alvo
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Imagem_Publico_Alvo extends ORM {

	protected $_table_name = 'imagens_publicos_alvos';
	protected $_primary_key = 'id_imagem_publico_alvo';

	protected $_table_columns = array(
		'id_imagem_publico_alvo' => NULL,
		'id_imagem' => NULL,
		'id_publico_alvo' => NULL,
	);

	protected $_belongs_to = array(
		'imagem' => array('model' => 'Imagem', 'foreign_key' => 'id_imagem'),
		'publico_alvo' => array('model' => 'Publico_Alvo', 'foreign_key' => 'id_publico_alvo'),
	);

	public function rules()
	{
		return array(
			'id_imagem_publico_alvo' => array(
				array('not_empty')
			),
			'id_imagem' => array(
				array('not_empty')
			),
			'id_publico_alvo' => array(
				array('not_empty')
			),
		);
	}
}