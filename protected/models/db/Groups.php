<?php

class Groups extends CActiveRecord
{

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
    return 'groups';
  }

  public function rules()
  {
    return array();
  }

  public function attributeLabels()
  {
    return array();
  }

  public function getGroups()
  {
    $search = $this->findAll();
    $result = array();
    foreach ($search as $s){
      $result[$s->id] = $s;
    }
    return $result;
  }

  // =================

}