<?php
/**
 * Token de autenticação de usuários
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Model_Usuario_Token extends ORM {
	protected $_table_name = 'usuarios_tokens';
	protected $_primary_key = 'id_usuario_token';

	protected $_table_columns = array(
		'id_usuario_token' => NULL,
		'id_usuario' => NULL,
		'token' => NULL,
		'user_agent' => NULL,
		'criacao' => NULL,
		'expiracao' => NULL
	);

	protected $_belongs_to = array(
		'usuario' => array('model' => 'Usuario', 'foreign_key' => 'id_usuario'),
	);

	protected $_created_column = array(
		'column' => 'criacao',
		'format' => 'Y-m-d H-i-s',
	);

	/**
	 * Construtor
	 * @return void
	 */
	public function __construct($id_usuario_token = NULL)
	{
		parent::__construct($id_usuario_token);

		// Aproximadamente a cada 100 verificacoes: chamar o GC
		if (mt_rand(1, 100) === 1) {
			$this->limpar_expirados();
		}

		if ($this->loaded() && strtotime($this->expiracao) < time()) {
			$this->delete();
		}
	}

	/**
	 * Garbage Collection
	 * @return self
	 */
	public function limpar_expirados()
	{
		DB::delete($this->_table_name)
			->where('expiracao', '<', strftime('%Y-%m-%d %H:%M:%S'))
			->execute($this->_db);

		return $this;
	}

	public function create(Validation $validation = NULL)
	{
		$this->token = $this->gerar_token();
		return parent::create($validation);
	}

	protected function gerar_token()
	{
		do {
			$token = sha1(uniqid(Text::random('alnum', 32), TRUE));
		} while (ORM::factory('Usuario_Token', array('token' => $token))->loaded());

		return $token;
	}

}
