<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
  private $_id;

  const ERROR_NONE             = 0;
  const ERROR_USERNAME_INVALID = 1;
  const ERROR_PASSWORD_INVALID = 2;
  const ERROR_USER_INACTIVE    = 3;

  /**
   * Authenticates a user.
   * @return boolean whether authentication succeeds.
   */
  public function authenticate()
  {
    $user=User::model()->find('LOWER(username)=?',array(strtolower($this->username)));
    if($user===null)
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    else if(!$user->validatePassword($this->password))
      $this->errorCode = self::ERROR_PASSWORD_INVALID;
    else
    {
      $this->_id = $user->id;
      $this->username = $user->username;
        $this->setState('email', $user->email);
        $this->setState('fname', $user->fname);
        $this->setState('lname', $user->lname);
        $this->setState('role', $user->role);
      $this->errorCode=self::ERROR_NONE;
    }
    return $this->errorCode;
  }

  /**
   * @return string with user avatar
   */
  public function getAva($user)
  {
    if ($user->avatar != NULL){
      return "/uploads/images/avatars/$user->avatar";
    }else{
      return '/images/noava.png';
    }
    
  }

  /**
   * @return integer the ID of the user record
   */
  public function getId()
  {
    return $this->_id;
  }
}