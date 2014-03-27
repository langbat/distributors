<?php

class Photos extends CActiveRecord
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
    return 'photos';
  }

  public function rules()
  {
    return array();
  }

  public function attributeLabels()
  {
    return array();
  }

  public function getPhotosByDistributorId($id)
  {
    $photos = self::model()->findAllByAttributes(array('distributor_id' => $id), array('order' => 'upload_date asc'));
    
    $result = array();
    for($i=1;$i<7;$i++){
      $result[$i] = '/public/photos/no-photo.jpg';
    }
    foreach($photos as $p){
      $file = "/public/photos/".$p->name;
      if (file_exists('/srv/sites/taursus.com/www'.$file)){
        $result[$p->photo_type] = $file;
      }
    }
    return $result;
    vd($result, true);
  }

}