<?php

class OrdersQuantity extends CActiveRecord
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
    return 'orders_quantity';
  }

  public function rules()
  {
    return array();
  }

  public function attributeLabels()
  {
    return array();
  }

  // =================

}