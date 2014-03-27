<?php

class CategoryController extends Controller {
  
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
    $this->redirect('/category/list');
  }

  public function actionList()
  {
      $categories = ProductsCategories::model()->findAll();
      $companies = Companies::model()->getCompanies();
      $this->render('list', array('categories' => $categories, 'companies' => $companies));
  }

  public function actionAdd()
  {
    $data = Yii::app()->request->getPost('data', false);
    $companies = Companies::model()->getCompanies();
    if ($data){
      $category = new ProductsCategories();
      $category->title = $data['name'];
      $category->company_id = $data['company_id'];
      $category->save();

      $this->render('success');
    }else{
      $this->render('add', array('companies' => $companies));
    }
  }

  public function actionEdit($id)
  {
    if($id){

    }else{
      $this->redirect('/category/list');
    }
  }

  public function actionDelete($id)
  {
    if ($id){

    }else{
      $this->redirect('/category/list');
    }
  }

}