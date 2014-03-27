<?php

class TemplatesController extends Controller {
  
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
    $this->redirect('/templates/list');
  }

  public function actionList()
  {
      $templates = Templates::model()->findAll();
      $companies = Companies::model()->getCompanies();
      $this->render('list', array('templates' => $templates, 'companies' => $companies));
  }

  public function actionAdd()
  {
    $data = Yii::app()->request->getPost('data', false);
    $products = Yii::app()->request->getPost('products', false);
    $companies = Companies::model()->getCompanies();
    $discounts = Yii::app()->request->getPost('discounts', false);
    if ($data){
      //var_dump($_POST);
      $settings = array();
      foreach($discounts as $key => $value){
        $params = explode('-', $key);
        $settings[$params[1]][] = $params[2];
      }
      //pr($products); die();

      $template = new Templates();
      $template->title = $data['name'];
      $template->description = $data['description'];
      $template->settings = CJSON::encode($settings);
      $template->company_id = $data['company_id'];
      $template->save();

      foreach($products as $product){
        $template_product = new TemplatesProducts();
        $template_product->template_id = $template->id;
        $template_product->product_id = $product;
        $template_product->save();
      }

      $this->render('success', array('template' => $template));
    }else{
      $this->render('add', array('companies' => $companies));
    }
  }

  public function actionAjax()
  {
    $company_id = Yii::app()->request->getPost('company', false);
    $discounts = array('20' => true, '40' => true, '75' => true, '100' => true);

    $categories = ProductsCategories::model()->findAllByAttributes(array('company_id' => $company_id));
    $result = array();
    foreach ($categories as $category){
      $temp = array();
      $temp['category'] = $category;
      $temp['products'] = Products::model()->findAllByAttributes(array('category_id' => $category->id));
      $result[] = $temp;
    }
    $this->render('ajax', array('search' => $result, 'discounts' => $discounts));
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