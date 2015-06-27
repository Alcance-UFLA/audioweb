<?php
/**
 * Driver de autenticacao de usuarios no AudioWeb
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Auth_AudioWeb extends Auth {

	const COOKIE_LEMBRAR_LOGIN = 'autologinaudioweb';

	/**
	 * Checa se um usuário está logado e se possui determinado perfil
	 * @param string $perfil
	 * @return bool
	 */
	public function logged_in($perfil = NULL)
	{
		$usuario = $this->get_user();

		if ( ! $usuario) {
			return FALSE;
		}

		if ( ! ($usuario instanceof Model_Usuario) OR ! $usuario->loaded()) {
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * Loga um usuario
	 * @param string | Model_Usuario $email
	 * @param string $senha
	 * @param bool $lembrar
	 * @return bool
	 */
	protected function _login($email, $senha, $lembrar)
	{
		$usuario = $this->_obter_usuario_email($email);

		if ($usuario->senha !== $this->hash($senha)) {
			return FALSE;
		}

		if ($lembrar) {

			$dados = array(
				'id_usuario' => $usuario->pk(),
				'expiracao'  => strftime('%Y-%m-%d %H:%M:%S', time() + $this->_config['lifetime']),
				'user_agent' => sha1(Request::$user_agent),
			);

			$token = ORM::factory('Usuario_Token')
						->values($dados)
						->create();

			Cookie::set(
				self::COOKIE_LEMBRAR_LOGIN,
				$token->token,
				$this->_config['lifetime']
			);
		}

		$this->complete_login($usuario);

		return TRUE;
	}

	/**
	 * Força o login com um usuário, sem passar a senha
	 * @param string | Model_Usuario $email
	 * @param bool $marcar_sessao_forcada
	 * @return bool
	 */
	public function force_login($email, $marcar_sessao_forcada = FALSE)
	{
		$usuario = $this->_obter_usuario_email($email);

		if ($marcar_sessao_forcada) {
			$this->_session->set('auth_forced', TRUE);
		}

		$this->complete_login($usuario);
	}

	/**
	 * Loga um usuario com base no valor do cookie de lembrar
	 * @return  mixed
	 */
	public function auto_login()
	{
		$token_string = Cookie::get(self::COOKIE_LEMBRAR_LOGIN);
		if ( ! $token_string) {
			return FALSE;
		}

		$token = ORM::factory('Usuario_Token', array('token' => $token_string));

		if ( ! $token->loaded()) {
			return FALSE;
		}
		if ( ! $token->usuario->loaded()) {
			return FALSE;
		}
		if ($token->user_agent !== sha1(Request::$user_agent)) {
			$token->delete();
			return FALSE;
		}

		$this->complete_login($token->usuario);
		return $token->usuario;
	}

	/**
	 * Obtém o usuário logado (com checagem de login automático)
	 * Retorna $default se não encontrar nenhum.
	 * @param mixed  $default Valor retornado caso nenhum usuário esteja logado
	 * @return mixed
	 */
	public function get_user($default = NULL)
	{
		$usuario = parent::get_user($default);

		if ($usuario === $default) {
			$usuario = $this->auto_login();
			if ($usuario === FALSE) {
				return $default;
			}
		}

		return $usuario;
	}

	/**
	 * Desloga um usuário.
	 * @param bool $destruir Destroi completamente a sessao
	 * @param bool $apagar_tokens_usuario Apaga todos tokens do usuario
	 * @return bool
	 */
	public function logout($destruir = FALSE, $apagar_tokens_usuario = FALSE)
	{
		$usuario = $this->get_user();
		$this->_session->delete('auth_forced');

		$token = Cookie::get(self::COOKIE_LEMBRAR_LOGIN);
		if ($token) {
			Cookie::delete(self::COOKIE_LEMBRAR_LOGIN);
			$obj_token = ORM::factory('Usuario_Token', array('token' => $token));
			if ($obj_token->loaded()) {
				$obj_token->delete();
			}
		}

		if ($usuario && $apagar_tokens_usuario) {
			$tokens = ORM::factory('Usuario_Token')->where('id_usuario', '=', $usuario->id_usuario)->find_all();
			foreach ($tokens as $token) {
				$token->delete();
			}
		}

		return parent::logout($destruir);
	}

	/**
	 * Obtém a senha de um usuário.
	 * @param string | Model_Usuario $email
	 * @return string
	 */
	public function password($email)
	{
		$usuario->_obter_usuario_email($email);
		return $usuario->senha;
	}

	/**
	 * Completa o login atualizando a sessão.
	 * @param Model_Usuario $usuario
	 * @return void
	 */
	protected function complete_login($usuario)
	{
		$usuario->complete_login();
		return parent::complete_login($usuario);
	}

	/**
	 * Compara uma senha com a obtida do usuário logado.
	 * @param string $senha
	 * @return bool
	 */
	public function check_password($senha)
	{
		$usuario = $this->get_user();

		if ( ! $usuario) {
			return FALSE;
		}

		return $this->hash($senha) === $usuario->senha;
	}

	private function _obter_usuario_email($email)
	{
		if ($email instanceof Model_Usuario) {
			return $email;
		}

		$usuario = ORM::factory('Usuario');
		$usuario->where('email', '=', $email)->find();

		return $usuario;
	}

}
