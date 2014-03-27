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
      array('username, password', 'required'),
      // rememberMe needs to be a boolean
      array('rememberMe', 'boolean'),
      // password needs to be authenticated
      array('password', 'authenticate'),
    );
  }

  /**
   * Declares attribute labels.
   */
  public function attributeLabels()
  {
    return array(
      'username' => 'Username',
      'password' => 'Password',
    );
  }

  /**
   * Authenticates the password.
   * This is the 'authenticate' validator as declared in rules().
   */
  public function authenticate($attribute,$params)
  {
    $this->_identity=new UserIdentity($this->username,$this->password);
    $result = $this->_identity->authenticate();
    switch($result) {
      case 0:
      default: 
        break;
      case 1:
        $this->addError('username', 'Incorrect login');
        break;
      case 2:
        $this->addError('password', 'Incorrect password');
        break;
      case 3:
        $this->addError('inactive', 'Your account is not activated');
        break;
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
      $duration = 3600*24*30; // 30 days
      Yii::app()->user->login($this->_identity,$duration);
      return true;
    } else
      return $this->_identity->errorCode;
  }
}
