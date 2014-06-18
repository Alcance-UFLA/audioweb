<?php
/**
 * Driver de autenticacao de usuarios no Audio Imagem
 * @author Rubens Takiguti Ribeiro <rubs33@gmail.com>
 */
class Auth_AudioImagem extends Auth {

	const COOKIE_LEMBRAR_LOGIN = 'autologinaudioimagem';

	/**
	 * Checa se um usuário está logado e se possui determinado perfil
	 * @param string $perfil Perfil 'P' ou 'E'
	 * @return bool
	 */
	public function logged_in($perfil = NULL)
	{
		$usuario = $this->get_user();

		if ( ! $usuario)
		{
			return FALSE;
		}

		if ($usuario instanceof Model_Usuario AND $usuario->loaded())
		{
			if ( ! $perfil)
			{
				return TRUE;
			}

			return $usuario->perfil == $perfil;
		}
		return FALSE;
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
		if ($email instanceof Model_Usuario)
		{
			$usuario = $email;
		}
		else
		{
			$usuario = ORM::factory('Usuario');
			$usuario->where('email', '=', $email)->find();
		}

		if ($usuario->senha !== $this->hash($senha))
		{
			return FALSE;
		}

		if ($lembrar)
		{
			$dados = array(
				'id_usuario' => $usuario->pk(),
				'expires'    => time() + $this->_config['lifetime'],
				'user_agent' => sha1(Request::$user_agent),
			);

			$token = ORM::factory('Usuario_Token')
						->values($dados)
						->create();

			Cookie::set(self::COOKIE_LEMBRAR_LOGIN, $token->token, $this->_config['lifetime']);
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
		if ($email instanceof Model_Usuario)
		{
			$usuario = $email;
		}
		else
		{
			$usuario = ORM::factory('Usuario');
			$usuario->where('email', '=', $email)->find();
		}

		if ($marcar_sessao_forcada)
		{
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
		$token = Cookie::get(self::COOKIE_LEMBRAR_LOGIN);
		if ( ! $token)
		{
			return FALSE;
		}

		$token = ORM::factory('Usuario_Token', array('token' => $token));

		if ($token->loaded() && $token->user->loaded() && $token->user_agent === sha1(Request::$user_agent))
		{
			$token->save();
			Cookie::set(self::COOKIE_LEMBRAR_LOGIN, $token->token, $token->expires - time());
			$this->complete_login($token->usuario);
			return $token->usuario;
		}

		$token->delete();
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

		if ($usuario === $default)
		{
			if (($usuario = $this->auto_login()) === FALSE)
				return $default;
		}

		return $usuario;
	}

	/**
	 * Desloga um usuário.
	 * @param bool $destruir Destroi completamente a sessao
	 * @param bool $remover_tokens Remove todos tokens do usuário
	 * @return bool
	 */
	public function logout($destruir = FALSE, $remover_tokens = FALSE)
	{
		$this->_session->delete('auth_forced');

		if ($token = Cookie::get(self::COOKIE_LEMBRAR_LOGIN))
		{
			Cookie::delete(self::COOKIE_LEMBRAR_LOGIN);

			$token = ORM::factory('Usuario_Token', array('token' => $token));

			if ($token->loaded() AND $remover_tokens)
			{
				$tokens = ORM::factory('Usuario_Token')->where('id_usuario', '=', $token->id_usuario)->find_all();

				foreach ($tokens as $_token)
				{
					$_token->delete();
				}
			}
			elseif ($token->loaded())
			{
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
		if ($email instanceof Model_Usuario)
		{
			$usuario = $email;
		}
		else
		{
			$usuario = ORM::factory('Usuario');
			$usuario->where('email', '=', $email)->find();
		}

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

		if ( ! $usuario)
		{
			return FALSE;
		}

		return $this->hash($senha) === $usuario->senha;
	}

}
