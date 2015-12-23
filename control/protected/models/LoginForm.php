<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $usuario;
	public $contrasenia;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that usuario and contrasenia are required,
	 * and contrasenia needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// usuario and contrasenia are required
			array('usuario, contrasenia', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// contrasenia needs to be authenticated
			array('contrasenia', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the contrasenia.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->usuario,$this->contrasenia);
			if(!$this->_identity->authenticate())
				$this->addError('contrasenia','Incorrect usuario or contrasenia.');
		}
	}

	/**
	 * Logs in the user using the given usuario and contrasenia in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->usuario,$this->contrasenia);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
