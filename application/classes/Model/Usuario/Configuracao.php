<?php
/**
 * Model Usuario_Configuracao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Usuario_Configuracao extends ORM {

	protected $_table_name = 'usuarios_configuracoes';
	protected $_primary_key = 'id_usuario_configuracao';

	protected $_table_columns = array(
		'id_usuario_configuracao' => NULL,
		'valor_personalisado' => NULL,
		'id_configuracao' => NULL,
		'id_usuario' => NULL,
	);

	protected $_belongs_to = array(
		'configuracao' => array('model' => 'Configuracao', 'foreign_key' => 'id_configuracao'),
		'usuario' => array('model' => 'Usuario', 'foreign_key' => 'id_usuario'),
	);

	public function rules()
	{
		return array(
			'id_usuario_configuracao' => array(
				array('not_empty')
			),
			'valor_personalisado' => array(
				array('not_empty')
			),
			'id_configuracao' => array(
				array('not_empty')
			),
			'id_usuario' => array(
				array('not_empty')
			),
		);
	}
}