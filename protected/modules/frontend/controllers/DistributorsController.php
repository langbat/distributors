<?php

class DistributorsController extends Controller {
  
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
    $this->redirect("/distributors/list");
  }

  public function actionAdd()
  {
    $data = Yii::app()->request->getPost('data', false);

    if ($data){
      $distributors = new Distributors();
      $distributors->title = $data['name'];
      $distributors->image = "default.png";
      $distributors->company_id = $data['company_id'];
      $distributors->owner_name = $data['oname'];
      $distributors->contact_name = $data['cname'];
      $distributors->address = $data['address'];
      $distributors->address2 = $data['address2'];
      $distributors->city = $data['town'];
      $distributors->state_id = $data['state'];
      $distributors->professional_id = $data['pro'];
      $distributors->region_id = $data['region'];
      $distributors->group_id = $data['group'];
      $distributors->supplier_id = $data['supplier'];
      $distributors->api = $data['api'];
      $distributors->zip = $data['postcode'];
      $distributors->phone = $data['phone'];
      $distributors->fax = $data['fax'];
      $distributors->email = $data['email'];
      $distributors->status = $data['status'];
      $distributors->join_date = "0000-00-00 00:00:00";
      $distributors->longitude = $data['long'];
      $distributors->latitude = $data['lat'];
      $distributors->trading_hours = $this->_trading_hours($data);

      $distributors->save();

      $this->render('success', array('id' => $distributors->id));
    }else{
      $states = States::model()->findAll();
      $suppliers = Suppliers::model()->findAll();
      $groups = Groups::model()->findAll();
      $professional = Professional::model()->findAll();
      $regions = Regions::model()->findAll();
      $this->render('add', array('states' => $states, 'suppliers' => $suppliers, 'groups' => $groups, 'professional' => $professional, 'regions' => $regions));
    }
  }

  public function actionList()
  {
    $search = Yii::app()->request->getPost('search', false);
    $suppliers = Suppliers::model()->getSuppliers();
    $groups = Groups::model()->getGroups();
    $states = States::model()->getStates();
    $regions = Regions::model()->getRegions();

    if ($search){
      $criterias = array();
      if ((int)$search['status'] != 0){
        $criterias['status'] = (int)$search['status'];
      }
      if ((int)$search['supplier'] != 0){
        $criterias['supplier_id'] = (int)$search['supplier'];
      }
      if ((int)$search['groups'] != 0){
        $criterias['group_id'] = (int)$search['groups'];
      }
      if ((int)$search['states'] != 0){
        $criterias['state_id'] = (int)$search['states'];
      }
      if ((int)$search['regions'] != 0){
        $criterias['region_id'] = (int)$search['regions'];
      }
      if ((int)$search['company_id'] != 0 && (int)$search['company_id'] != 3){
        $criterias['company_id'] = (int)$search['company_id'];
      }
      $distributors = Distributors::model()->findAllByAttributes($criterias);
    }else{
      $distributors = Distributors::model()->findAll();
    }
    if ($search['export'] != 0){
        $CSV = new Csv();
        $CSV->export($distributors);
        header("Location: /public/file.csv");
    }
    $this->render('list', array(
      'distributors' => $distributors, 
      'search' => $search, 
      'suppliers' => $suppliers, 
      'groups' => $groups,
      'states' => $states,
      'regions' => $regions
      )
    );
  }

  public function actionMap()
  {
    $search = Yii::app()->request->getPost('search', array('status' => 1, 'supplier' => 0, 'groups' => 0, 'states' => 0, 'regions' => 0, 'company_id' => 0));
    $suppliers = Suppliers::model()->getSuppliers();
    $groups = Groups::model()->getGroups();
    $states = States::model()->getStates();
    $regions = Regions::model()->getRegions();

    if ($search){
      $criterias = array();
      if ((int)$search['status'] != 0){
        $criterias['status'] = (int)$search['status'];
      }
      if ((int)$search['supplier'] != 0){
        $criterias['supplier_id'] = (int)$search['supplier'];
      }
      if ((int)$search['groups'] != 0){
        $criterias['group_id'] = (int)$search['groups'];
      }
      if ((int)$search['states'] != 0){
        $criterias['state_id'] = (int)$search['states'];
      }
      if ((int)$search['regions'] != 0){
        $criterias['region_id'] = (int)$search['regions'];
      }
      if ((int)$search['company_id'] != 0 && (int)$search['company_id'] != 3){
        $criterias['company_id'] = (int)$search['company_id'];
      }
      $distributors = Distributors::model()->findAllByAttributes($criterias);
    }else{
      $distributors = Distributors::model()->findAll();
    }
    $this->render('map', array(
      'distributors' => $distributors, 
      'search' => $search, 
      'suppliers' => $suppliers, 
      'groups' => $groups,
      'states' => $states,
      'regions' => $regions
      )
    );
  }

  public function actionEdit($id)
  {
    if ($id){

      $distributor = Distributors::model()->findByPk((int)$id);
      $data = Yii::app()->request->getPost('data', false);

      if ($data){
        $distributor->title = $data['name'];
        $distributor->image = "default.png";
        $distributor->company_id = $data['company_id'];
        $distributor->owner_name = $data['oname'];
        $distributor->contact_name = $data['cname'];
        $distributor->address = $data['address'];
        $distributor->address2 = $data['address2'];
        $distributor->city = $data['town'];
        $distributor->state_id = $data['state'];
        $distributor->professional_id = $data['pro'];
        $distributor->region_id = $data['region'];
        $distributor->group_id = $data['group'];
        $distributor->supplier_id = $data['supplier'];
        $distributor->api = $data['api'];
        $distributor->zip = $data['postcode'];
        $distributor->phone = $data['phone'];
        $distributor->fax = $data['fax'];
        $distributor->email = $data['email'];
        $distributor->trading_hours = "";
        $distributor->status = $data['status'];
        $distributor->join_date = "0000-00-00 00:00:00";
        $distributor->longitude = $data['long'];
        $distributor->latitude = $data['lat'];

        $distributor->save();

        $this->redirect('/distributors/map');
      }else{
        $states = States::model()->findAll();
        $suppliers = Suppliers::model()->findAll();
        $groups = Groups::model()->findAll();
        $professional = Professional::model()->findAll();
        $regions = Regions::model()->findAll();
        $this->render('edit', array('states' => $states, 'suppliers' => $suppliers, 'groups' => $groups, 'professional' => $professional, 'regions' => $regions, 'd' => $distributor));
      }
    }else{
      $this->redirect('/distributors/list');
    }
  }

  public function actionView($id)
  {
    if ($id){
        $distributor = Distributors::model()->findByPk($id);
        if ($distributor){
            $state = States::model()->findByPk($distributor->state_id);
            if ($distributor->region_id != 0){
                $region = Regions::model()->findByPk($distributor->region_id);
            }else{
                $region = '';
            }
            if ($distributor->supplier_id != 0){
                $supplier = Suppliers::model()->findByPk($distributor->supplier_id);
            }else{
                $supplier = '';
            }
            if ($distributor->professional_id != 0){
                $pro = Professional::model()->findByPk($distributor->professional_id);
            }else{
                $pro = '';
            }
            if ($distributor->group_id != 0){
                $group = Groups::model()->findByPk($distributor->group_id);
            }else{
                $group = '';
            }
            $photos = Photos::getPhotosByDistributorId($distributor->id);
            $orders = Orders::model()->findAllByAttributes(array('distributor_id' =>$distributor->id));
            $contact_logs = ContactLogs::model()->findAllByAttributes(array('distributor_id' => $distributor->id, 'status' => 1), array('order' => 'log_date desc'));
            $users = User::model()->sortById();
            $this->render(
              'view', 
              array(
                'distributor'   => $distributor, 
                'state'         => $state, 
                'region'        => $region, 
                'pro'           => $pro, 
                'group'         => $group, 
                'supplier'      => $supplier, 
                'photos'        => $photos, 
                'contact_logs'  => $contact_logs, 
                'users'         => $users,
                'orders'        => $orders
              )
            );
        }else{
            $this->redirect('/distributors/list');
        }
    }else{
        $this->redirect('/distributors/list');
    }

  }

  public function actionDelete($id)
  {
    if ($id){
      $distributor = Distributors::model()->findByPk((int)$id);
      if ($distributor){
        $distributor->delete();
      }
    }
    $this->redirect('/distributors/list');
  }

  public function actionProfessionallist()
  {
      $pro = Professional::model()->findAll();
      $this->render('professional/list', array('pro' => $pro));
  }

  public function actionProfessionaladd()
  {
      $data = Yii::app()->request->getPost('data', false);
      if($data){
        $pro = new Professional();
        $pro->title = $data['title'];
        $pro->save();

        $this->redirect('/distributors/professional/list');
      }else{
        $this->render('professional/add');
      }
  }

  public function actionProfessionaledit($id)
  {
      if ($id){
        $pro = Professional::model()->findByPk($id);
        $data = Yii::app()->request->getPost('data', false);
          if($data && $pro){
            $pro->title = $data['title'];
            $pro->save();

            $this->redirect('/distributors/professional/list');
          }else{
            $this->render('professional/edit', array('pro' => $pro));
          }
      }
  }

  public function actionProfessionaldelete($id)
  {
      if ($id){
        $pro = Professional::model()->findByPk($id);
        $data = Yii::app()->request->getPost('data', false);
        if($data){
          $pro->delete();
          $this->redirect('/distributors/professional/list');
        }else{
          $this->render('professional/delete', array('pro' => $pro));
        }
      }
  }

  public function actionGroupslist()
  {
      $groups = Groups::model()->findAll();
      $this->render('groups/list', array('groups' => $groups));
  }

  public function actionGroupsadd()
  {
      $data = Yii::app()->request->getPost('data', false);
      if($data){
        $group = new Groups();
        $group->title = $data['title'];
        $group->save();

        $this->redirect('/distributors/groups/list');
      }else{
        $this->render('groups/add');
      }
  }

  public function actionGroupsedit($id)
  {
      if ($id){
        $group = Groups::model()->findByPk($id);
        $data = Yii::app()->request->getPost('data', false);
          if($data && $group){
            $group->title = $data['title'];
            $group->save();

            $this->redirect('/distributors/groups/list');
          }else{
            $this->render('groups/edit', array('group' => $group));
          }
      }
  }

  public function actionGroupsdelete($id)
  {
      if ($id){
        $group = Groups::model()->findByPk($id);
        $data = Yii::app()->request->getPost('data', false);
        if($data){
          $group->delete();
          $this->redirect('/distributors/groups/list');
        }else{
          $this->render('groups/delete', array('group' => $group));
        }
      }
  }

  public function actionSupplierslist()
  {
      $suppliers = Suppliers::model()->findAll();
      $this->render('suppliers/list', array('suppliers' => $suppliers));
  }

  public function actionSuppliersadd()
  {
      $data = Yii::app()->request->getPost('data', false);
      if($data){
        $supplier = new Suppliers();
        $supplier->title = $data['title'];
        $supplier->save();

        $this->redirect('/distributors/suppliers/list');
      }else{
        $this->render('suppliers/add');
      }
  }

  public function actionSuppliersedit($id)
  {
      if ($id){
        $supplier = Suppliers::model()->findByPk($id);
        $data = Yii::app()->request->getPost('data', false);
          if($data && $supplier){
            $supplier->title = $data['title'];
            $supplier->save();

            $this->redirect('/distributors/suppliers/list');
          }else{
            $this->render('suppliers/edit', array('supplier' => $supplier));
          }
      }
  }

  public function actionSuppliersdelete($id)
  {
      if ($id){
        $supplier = Suppliers::model()->findByPk($id);
        $data = Yii::app()->request->getPost('data', false);
        if($data){
          $supplier->delete();
          $this->redirect('/distributors/suppliers/list');
        }else{
          $this->render('suppliers/delete', array('supplier' => $supplier));
        }
      }
  }

  public function actionRegions()
  {
      $regions = Regions::model()->findAll();
      $states = States::model()->getStates();
      $this->render('regions', array('regions' => $regions, 'states' => $states));
  }

  private function _trading_hours($data){
    $trading_hours = array();
      if (isset($data['monday'])){
        $trading_hours['monday']['start'] = $data['monday_start'];
        $trading_hours['monday']['end'] = $data['monday_end'];
      }else{
        $trading_hours['monday'] = false;
      }
      if (isset($data['tuesday'])){
        $trading_hours['tuesday']['start'] = $data['tuesday_start'];
        $trading_hours['tuesday']['end'] = $data['tuesday_end'];
      }else{
        $trading_hours['tuesday'] = false;
      }
      if (isset($data['wednesday'])){
        $trading_hours['wednesday']['start'] = $data['wednesday_start'];
        $trading_hours['wednesday']['end'] = $data['wednesday_end'];
      }else{
        $trading_hours['wednesday'] = false;
      }
      if (isset($data['thursday'])){
        $trading_hours['thursday']['start'] = $data['thursday_start'];
        $trading_hours['thursday']['end'] = $data['thursday_end'];
      }else{
        $trading_hours['thursday'] = false;
      }
      if (isset($data['friday'])){
        $trading_hours['friday']['start'] = $data['friday_start'];
        $trading_hours['friday']['end'] = $data['friday_end'];
      }else{
        $trading_hours['friday'] = false;
      }
      if (isset($data['saturday'])){
        $trading_hours['saturday']['start'] = $data['saturday_start'];
        $trading_hours['saturday']['end'] = $data['saturday'];
      }else{
        $trading_hours['saturday'] = false;
      }
      if (isset($data['sunday'])){
        $trading_hours['sunday']['start'] = $data['sunday_start'];
        $trading_hours['sunday']['end'] = $data['sunday_end'];
      }else{
        $trading_hours['sunday'] = false;
      }

      return CJSON::encode($trading_hours);
  }

  public function actionAjax(){
    $request = Yii::app()->request->getPost('request', false);
    if ($request){
      $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".str_replace(' ', '+', $request)."&sensor=false";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$url);
      
      curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $result = curl_exec($ch);
      curl_close($ch);
      echo($result);
    }
  }

}