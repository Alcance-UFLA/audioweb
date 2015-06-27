<?php
/**
 * Model Usuario_Operacao
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Usuario_Operacao extends Model_Base {
	protected $_table_name = 'usuarios_operacoes';
	protected $_primary_key = 'id_usuario_operacao';

	protected $_table_columns = array(
		'id_usuario_operacao' => NULL,
		'tecla_personalisada' => NULL,
		'shift' => NULL,
		'alt' => NULL,
		'ctrl' => NULL,
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
			'tecla_personalisada' => array(
				array('not_empty')
			),
			'shift' => array(
				array('not_empty')
			),
			'alt' => array(
				array('not_empty')
			),
			'ctrl' => array(
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