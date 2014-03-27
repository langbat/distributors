<?php

class IndexController extends Controller {
  
  public function init()
  {
      if (Yii::app()->user->isGuest){
          $this->redirect('/users/signin');
      }
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = false;
    }
    parent::init();
  }


  public function actionIndex()
  {
    $contact_logs = ContactLogs::model()->findAllByAttributes(array('status' => 1), array('order' => 'log_date desc', 'limit' => 20, 'offset' => 0));
    $this->render('index', array('contact_logs' => $contact_logs));
  }
}