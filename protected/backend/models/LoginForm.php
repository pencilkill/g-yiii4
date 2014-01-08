<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	public $verifyCode;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password, verifyCode', 'required'),
			// captcha
			array('verifyCode', 'captcha'),
			// password needs to be authenticated
			array('password', 'authenticate'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
		);
	}

	public function safeAttributes() {
	    return array(
	        'verifyCode',
	    	'rememberMe',
	    );
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username' => Yii::t('m/loginform', 'Username'),
			'password' => Yii::t('m/loginform', 'Password'),
			'rememberMe' => Yii::t('m/loginform', 'Remember me next time'),
			'verifyCode' => Yii::t('m/loginform', 'Verify Code'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if($this->hasErrors())
		{
			Yii::app()->user->setFlash('warning', array_shift($this->getErrors('verifyCode')));
			return false;
		}else{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate()){
				Yii::app()->user->setFlash('warning', Yii::t('m/loginform', 'Incorrect username or password.'));
				return true;
			}
			return false;
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			// Override anyother setting if $duration set to 0
			// It means never auto logout ignoring user setting authTimeout
			$duration=$this->rememberMe ? 3600 * 24 * 30 : Yii::app()->user->authTimeout; // 30 days

			Yii::app()->user->login($this->_identity, $duration);

			return true;
		}
		else
			return false;
	}
}
