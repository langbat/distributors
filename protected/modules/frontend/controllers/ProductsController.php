<?php

class ProductsController extends Controller {
  
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
    $this->redirect('/products/list');
  }

  public function actionList()
  {
      $products = Products::model()->findAll();
      $categories = ProductsCategories::model()->getCategories();
      $companies = Companies::model()->getCompanies();
      $this->render('list', array('products' => $products, 'categories' => $categories, 'companies' => $companies));
  }

  public function actionAdd()
  {
    $data = Yii::app()->request->getPost('data', false);
    $categories = ProductsCategories::model()->getCategories();
    $companies = Companies::model()->getCompanies();
    if ($data){
      $product = new Products();
      $product->price = (float)$data['price'];
      $product->title = $data['name'];
      $product->api_pde = $data['api_pde'];
      $product->company_pde = $data['company_pde'];
      $product->category_id = $data['category_id'];
      $product->photo = $data['photo'];
      $product->save();

      $this->_photo_upload($data['photo']);

      $this->render('success');
    }else{
      $this->render('add', array('categories' => $categories, 'companies' => $companies));
    }

  }

  public function actionEdit($id)
  {
    if($id){
      $data = Yii::app()->request->getPost('data', false);
      $categories = ProductsCategories::model()->getCategories();
      $companies = Companies::model()->getCompanies();
      $product = Products::model()->findByPk($id);
      if ($data){
        $product->price = (float)$data['price'];
        $product->title = $data['name'];
        $product->api_pde = $data['api_pde'];
        $product->company_pde = $data['company_pde'];
        $product->category_id = $data['category_id'];
        $product->photo = $data['photo'];
        $product->update();

        $this->_photo_upload($data['photo']);

        $this->render('success');
      }else{
        $this->render('edit', array('categories' => $categories, 'companies' => $companies, 'product' => $product));
      }
    }else{
      $this->redirect('/products/list');
    }
  }

  public function actionDelete($id)
  {
    if ($id){
      $product = Products::model()->findByPk($id);
      if ($product){
        $product->delete();
        $this->redirect('/products/list');
      }
    }else{
      $this->redirect('/products/list');
    }
  }

  public function actionPhoto()
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

  private function _photo_upload($filename)
  {
    $uploadDir = '/public/products/';
    $tempFile  = $_SERVER['DOCUMENT_ROOT'] . '/public/photos/tmp/' . $filename;
    $targetFile = $_SERVER['DOCUMENT_ROOT'] . $uploadDir . $filename;
    rename($tempFile, $targetFile);
    
    return $filename;
  }

}