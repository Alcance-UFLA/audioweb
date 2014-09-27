<?php
/**
 * Model Usuario_Operacao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Usuario_Operacao extends ORM {

	protected $_table_name = 'usuarios_operacoes';
	protected $_primary_key = 'id_usuario_operacao';

	protected $_table_columns = array(
		'id_usuario_operacao' => NULL,
		'tecla_personalisada' => NULL,
		'id_operacao' => NULL,
		'id_usuario' => NULL,
	);

	protected $_belongs_to = array(
		'usuario' => array('model' => 'Usuario', 'foreign_key' => 'id_usuario'),
		'operacao' => array('model' => 'Operacao', 'foreign_key' => 'id_operacao'),
	);

	public function rules()
	{
		return array(
			'id_usuario_operacao' => array(
				array('not_empty')
			),
			'tecla_personalisada' => array(
				array('not_empty')
			),
			'id_operacao' => array(
				array('not_empty')
			),
			'id_usuario' => array(
				array('not_empty')
			),
		);
	}
}