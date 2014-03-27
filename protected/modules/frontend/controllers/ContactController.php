<?php

class ContactController extends Controller {
  
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
    $this->redirect('/contact/list');
  }

  public function actionList()
  {
    $contact_logs = ContactLogs::model()->findAll(array('order' => 'log_date desc'));
    $users = User::model()->sortById();
    $this->render('list', array('contact_logs' => $contact_logs, 'users' => $users));
  }

  public function actionCreate($id)
  {
    if ($id){
      $distributor = Distributors::model()->findByPk($id);
      $data = Yii::app()->request->getPost('data', false);

      if ($data){
        $log = new ContactLogs();

        $log->log_date = $data['log_date'];
        $log->contact_method = (int)$data['contact_method'];
        $log->contact_reason = (int)$data['contact_reason'];
        $log->user_id = Yii::app()->user->id;
        $log->distributor_id = $distributor->id;
        $log->contact_comment = $data['contact_comment'];
        if ($data['action'] === 'save'){
          $log->status = 1;
          $type = 'new';
        }else{
          $log->status = 0;
          $type = 'draft';
        }
        $log->save();

        $photos = Yii::app()->request->getPost('photos', false);
        if ($photos){
          if ($photos['outside'] != ''){
            $this->_photo_upload(1, $photos['outside'], $distributor->id, $data['log_date'], $log->id);
          }
          if ($photos['before'] != ''){
            $this->_photo_upload(2, $photos['before'], $distributor->id, $data['log_date'], $log->id);
          }
          if ($photos['after'] != ''){
            $this->_photo_upload(3, $photos['after'], $distributor->id, $data['log_date'], $log->id);
          }
          if ($photos['display'] != ''){
            $this->_photo_upload(4, $photos['display'], $distributor->id, $data['log_date'], $log->id);
          }
          if ($photos['optional'] != ''){
            $this->_photo_upload(5, $photos['optional'], $distributor->id, $data['log_date'], $log->id);
          }
          if ($photos['staff'] != ''){
            $this->_photo_upload(6, $photos['staff'], $distributor->id, $data['log_date'], $log->id);
          }
        }

        $this->render('success', array('type' => $type));
      }else{
        $this->render('create', array('distributor' => $distributor));
      }
    }else{
      $this->redirect('/contact/list');
    }
  }

  public function actionEdit($id)
  {
    if ($id){
      $log = ContactLogs::model()->findByPk($id);
      $distributor = Distributors::model()->findByPk($log->distributor_id);
      $data = Yii::app()->request->getPost('data', false);
      if ($data){
        $log->log_date = $data['log_date'];
        $log->contact_method = (int)$data['contact_method'];
        $log->contact_reason = (int)$data['contact_reason'];
        $log->user_id = Yii::app()->user->id;
        $log->distributor_id = $distributor->id;
        $log->contact_comment = $data['contact_comment'];
        if ($data['action'] === 'save'){
          $log->status = 1;
          $type = 'new';
        }else{
          $log->status = 0;
          $type = 'draft';
        }
        $log->update();

        $this->render('success', array('type' => $type));
      }else{
        $this->render('edit', array('distributor' => $distributor, 'contact_log' => $log));
      }
    }else{
      $this->redirect('/contact/list');
    }
  }

  public function actionDelete($id)
  {
    $log = ContactLogs::model()->findByPk($id);
    if (Yii::app()->user->role == 'admin' && $log){
      if (Yii::app()->request->isPostRequest){
        $log->delete();
        $this->render('delete', array('success' => true));
      }else{
        $this->render('delete', array());
      }
    }else{
      $this->redirect('/contact/list');
    }
  }

  public function actionView()
  {

  }

  public function actionUpload()
  {
    $uploadDir = '/public/photos/tmp/';
    //var_dump($_POST); die();

    // Set the allowed file extensions
    $fileTypes = array('jpg', 'jpeg', 'gif', 'png'); // Allowed file extensions

    //$verifyToken = md5('unique_salt' . $_POST['timestamp']);

    if (!empty($_FILES)) {
      $tempFile   = $_FILES['uploads']['tmp_name'][0];
      $uploadDir  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir;

      // Validate the filetype
      $fileParts = pathinfo($_FILES['uploads']['name'][0]);
      if (in_array(strtolower($fileParts['extension']), $fileTypes)) {

        $uid = uniqid();
        $filename = $uid . '.' . $fileParts['extension'];
        $targetFile = $uploadDir . $filename;
        
        // Save the file
        move_uploaded_file($tempFile, $targetFile);
        echo CJSON::encode(array('file' => '/public/photos/tmp/'.$filename, 'filename' => $filename));
      } else {
        // The file type wasn't allowed
        echo 'Invalid file type.';
      }
    }
  }

  private function _photo_upload($type, $filename, $did, $log_date, $clid)
  {
    $uploadDir = '/public/photos/';
    $tempFile  = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . 'tmp/' . $filename;
    $targetFile = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $filename;
    rename($tempFile, $targetFile);
    
    $photo = new Photos();
    $photo->distributor_id = $did;
    $photo->name = $filename;
    $photo->photo_type = $type;
    $photo->upload_date = date("Y-m-d H:i:s");
    $photo->show_photo = 1;
    $photo->visit_date = $log_date;
    $photo->user_id = Yii::app()->user->id;
    $photo->contact_log_id = $clid;
    $photo->save();
    return true;
  }

}