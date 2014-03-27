<?php

class UsersController extends Controller
{

  public function actionList()
  {
      $users = User::model()->findAll();
      $this->render('list', array('users' => $users));
  }

  public function actionSignin()
  {
    $model = new LoginForm;
    if (Yii::app()->request->isPostRequest) {
      $userData = Yii::app()->request->getPost('user', false);

      $model->attributes=$userData;

      // validate user input and redirect to the previous page if valid
      if($model->validate() && $model->login()) {
        $this->redirect('/');
      } else {
        $this->render('signin', array('form' => $model));
      }
    } else {
      $this->render('signin', array('form' => $model));
    }
  }

  public function actionAdd()
  {
    if (Yii::app()->user->role == 'admin'){
      if (Yii::app()->request->isPostRequest) {
        $userData = Yii::app()->request->getPost('data', false);
        
        $model = new User();
        $model->username = $userData['username'];
        $model->password = $model->hashPassword($userData['password']);
        $model->fname = $userData['fname'];
        $model->lname = $userData['lname'];
        $model->email = $userData['email'];
        $model->role = $userData['role'];
        $model->save();

        $this->render('add', array('success' => true));
      } else {
        $this->render('add', array());
      }
    }else{
      $this->redirect('/users/list/');
    }
  }

  public function actionEdit($id)
  {
    $user = User::model()->findByPk($id);
    if ($user && Yii::app()->user->role == 'admin'){
      if (Yii::app()->request->isPostRequest) {
        $userData = Yii::app()->request->getPost('data', false);
        
        $user->username = $userData['username'];
        $user->fname = $userData['fname'];
        $user->lname = $userData['lname'];
        $user->email = $userData['email'];
        $user->role = $userData['role'];
        $user->update();

        $this->render('edit', array('success' => true));
      } else {
        $this->render('edit', array('user' => $user));
      }
    }else{
      $this->redirect('/users/list');
    }
  }

  public function actionDelete($id)
  {
    $user = User::model()->findByPk($id);
    if (Yii::app()->user->role == 'admin' && $user){
      if (Yii::app()->request->isPostRequest){
        $user->delete();
        $this->render('delete', array('success' => true));
      }else{
        $this->render('delete', array('user' => $user));
      }
    }else{
      $this->redirect('/users/list');
    }
  }

  public function actionAdmin()
  {
    $id = Yii::app()->request->getPost('id', false);
    $user = User::model()->findByPk($id);
    if (Yii::app()->user->role == 'admin' && $user && Yii::app()->request->isPostRequest){
        $user->role = 'admin';
        $user->update();
        echo CJSON::encode(array('result' => true));
    }else{
      echo CJSON::encode(array('result' => false));
    }
  }

  public function actionSignout()
  {
    Yii::app()->user->logout();
    $this->redirect('/');
  }

}