<?php
/**
 * Token de autenticacao de usuarios
 */
class Model_Usuario_Token extends ORM {

	protected $_table_name = 'usuarios_tokens';
	protected $_primary_key = 'id_usuario_token';

	// Relationships
	protected $_belongs_to = array(
		'usuario' => array('model' => 'Usuario'),
	);

	protected $_created_column = array(
		'column' => 'criacao',
		'format' => TRUE,
	);

	/**
	 * Construtor
	 * @return  void
	 */
	public function __construct($id_usuario_token = NULL)
	{
		parent::__construct($id_usuario_token);

		// Aproximadamente a cada 100 verificacoes: chamar o GC
		if (mt_rand(1, 100) === 1)
		{
			$this->delete_expired();
		}

		if ($this->expires < time() AND $this->_loaded())
		{
			$this->delete();
		}
	}

	/**
	 * Garbage Collection
	 * @return self
	 */
	public function delete_expired()
	{
		DB::delete($this->_table_name)
			->where('expires', '<', time())
			->execute($this->_db);

		return $this;
	}

	public function create(Validation $validation = NULL)
	{
		$this->token = $this->create_token();

		return parent::create($validation);
	}

	protected function create_token()
	{
		do
		{
			$token = sha1(uniqid(Text::random('alnum', 32), TRUE));
		}
		while (ORM::factory('Usuario_Token', array('token' => $token))->loaded());

		return $token;
	}

}
