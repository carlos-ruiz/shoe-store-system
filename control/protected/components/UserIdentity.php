<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $_perfil;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = Usuarios::model()->find("usuario=?",array($this->username));

		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($user->contrasenia!==base64_encode($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else{
			$this->_id=$user->id;
			Yii::app()->session['perfil'] = $user->perfil->nombre;
			Yii::app()->user->setState('perfil',$user->perfil->nombre);
			Yii::app()->user->setState('usuario_nombre',$user->usuario);
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId()
    {
        return $this->_id;
    }
}