<?php

class User extends CActiveRecord
{

  public $salt = 'hello321123';
  public $agreement;

  private $_identity;

  const ROLE_ADMIN = 'admin';
  const ROLE_USER = 'user';
  const ROLE_BLOCKED = 'blocked';


  /**
   * Returns the static model of the specified AR class.
   * @return CActiveRecord the static model class
   */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName()
  {
    return 'users';
  }




  public function rules()
  {
    return array();
  }

  public function attributeLabels()
  {
    return array();
  }

  public function relations()
  {
    return array();
  }

  public function scopes()
  {
    return array();
  }

  // =================



  public function beforeSave()
  {
    //$this->password = $this->hashPassword($this->password);
    //$this->registration_token = $this->generateRegistrationToken($this);
    parent::beforeSave();
    return true;
  }

  public function validatePassword($password)
  {
    return crypt($password,$this->salt) === $this->password;
  }

  public function hashPassword($password)
  {
    return crypt($password, $this->salt);
  }

  public function getAll()
  {
    $sql = "SELECT * FROM users;";
    return Yii::app()->db->createCommand($sql)->queryAll();
  }

  public function sortById()
  {
    $users = self::model()->findAll();
    $result = array();
    foreach ($users as $user){
      $result[$user->id] = $user->fname.' '.$user->lname;
    }
    return $result;
  }

}